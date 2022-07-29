-- Drops

DROP TABLE IF EXISTS "notification"
CASCADE;
DROP TABLE IF EXISTS faq
CASCADE;
DROP TABLE IF EXISTS wishlist
CASCADE;
DROP TABLE IF EXISTS user_message
CASCADE;
DROP TABLE IF EXISTS report
CASCADE;
DROP TABLE IF EXISTS review
CASCADE;
DROP TABLE IF EXISTS bid
CASCADE;
DROP TABLE IF EXISTS photo
CASCADE;
DROP TABLE IF EXISTS auction
CASCADE;
DROP TABLE IF EXISTS category
CASCADE;
DROP TABLE IF EXISTS users
CASCADE;

DROP TRIGGER IF EXISTS tr_bid_check_buyer
ON bid cascade;
DROP TRIGGER IF EXISTS tr_whishlist_check_buyer
ON wishlist cascade;
DROP TRIGGER IF EXISTS tr_change_auction_status
ON auction cascade;

DROP FUNCTION IF EXISTS check_buyer
() CASCADE;
DROP FUNCTION IF EXISTS change_auction_status
() CASCADE;

-- Tables

CREATE TABLE users
(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT username_uk UNIQUE,
    name TEXT,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    password TEXT NOT NULL,
    email TEXT NOT NULL CONSTRAINT email_uk UNIQUE,
    is_admin BOOLEAN NOT NULL,
    zip_code TEXT,
    address TEXT,
    profile_pic TEXT,
    rating INTEGER NOT NULL CONSTRAINT rating_ck CHECK ((rating >= 0) AND (rating <= 5)),
    user_status TEXT NOT NULL DEFAULT 'Good'
    ::text,
    deleted_at TEXT,
    remember_token TEXT,
    CONSTRAINT status_ck CHECK
    ((user_status = ANY
    (ARRAY['Good'::text, 'Warned'::text, 'Banned'::text])))
);

    CREATE TABLE category
    (
        id SERIAL PRIMARY KEY,
        name TEXT NOT NULL CONSTRAINT name_uk UNIQUE
    );

    CREATE TABLE auction
    (
        id SERIAL PRIMARY KEY,
        seller_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
        item_name TEXT NOT NULL,
        description TEXT NOT NULL,
        starting_price REAL CONSTRAINT starting_price_ck CHECK (starting_price > 0),
        current_price REAL CONSTRAINT current_price_ck CHECK (current_price >= starting_price),
        shipping_cost REAL,
        beginning_date TIMESTAMP DEFAULT CURRENT_DATE NOT NULL,
        end_date TIMESTAMP NOT NULL CONSTRAINT end_date_ck CHECK (end_date >= beginning_date),
        category_id INTEGER NOT NULL REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE,
        auction_status TEXT NOT NULL DEFAULT 'Open'
        ::text,
    payment TEXT NOT NULL,
    shipping TEXT NOT NULL,
    deleted_at TEXT,
    CONSTRAINT status_ck CHECK
        ((auction_status = ANY
        (ARRAY['Open'::text, 'Ended'::text, 'Disabled'::text]))),
    CONSTRAINT payment_ck CHECK
        ((payment = ANY
        (ARRAY['Paypal'::text, 'MBWay'::text, 'Visa/Mastercard'::text])))
);

        CREATE TABLE photo
        (
            id SERIAL PRIMARY KEY,
            auction_id INTEGER REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
            description TEXT,
            path TEXT NOT NULL
        );

        CREATE TABLE bid
        (
            id SERIAL PRIMARY KEY,
            authenticated_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
            auction_id INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
            amount REAL NOT NULL,
            "date" TIMESTAMP DEFAULT CURRENT_TIMESTAMP(0) NOT NULL
);

            CREATE TABLE review
            (
                id SERIAL PRIMARY KEY,
                buyer_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                seller_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                rating INTEGER NOT NULL CONSTRAINT rating_ck CHECK ((rating > 0) AND (rating <= 5)),
                comment TEXT,
                "date" TIMESTAMP
                WITH TIME zone DEFAULT now
                () NOT NULL
);

                CREATE TABLE report
                (
                    id SERIAL PRIMARY KEY,
                    authenticated_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                    user_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                    title TEXT NOT NULL,
                    content TEXT NOT NULL,
                    report_status TEXT NOT NULL DEFAULT 'Pending'
                    ::text,
    "date" TIMESTAMP
                    WITH TIME zone DEFAULT now
                    () NOT NULL,
    CONSTRAINT status_ck CHECK
                    ((report_status = ANY
                    (ARRAY['Open'::text, 'Solved'::text, 'Pending'::text])))
);

                    CREATE TABLE user_message
                    (
                        id SERIAL PRIMARY KEY,
                        sender_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                        receiver_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
                        message TEXT NOT NULL,
                        "date" TIMESTAMP
                        WITH TIME zone DEFAULT now
                        () NOT NULL
);

                        CREATE TABLE wishlist
                        (
                            id SERIAL PRIMARY KEY,
                            auction_id INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
                            authenticated_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE
                        );

                        CREATE TABLE faq
                        (
                            id SERIAL PRIMARY KEY,
                            question TEXT NOT NULL,
                            answer TEXT NOT NULL
                        );

                        CREATE TABLE "notification"
                        (
                            id SERIAL PRIMARY KEY,
                            subject TEXT NOT NULL,
                            description TEXT NOT NULL,
                            was_read BOOLEAN NOT NULL,
                            authenticated_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE
                        );

                        --INDEXES

                        CREATE INDEX id ON users USING hash
                        (email);
                        CREATE INDEX auction_id ON auction USING hash
                        (category_id);
                        CREATE INDEX auction_id2 ON auction USING btree
                        (seller_id);
                        CREATE INDEX bid_index ON bid USING btree
                        (authenticated_id, auction_id);
                        CREATE INDEX title_index ON auction USING GIST
                        (to_tsvector
                        ('english', item_name));

                        --TRIGGERS

                        CREATE FUNCTION check_buyer() RETURNS TRIGGER AS
$BODY$
                        BEGIN
                            IF EXISTS (SELECT *
                            FROM auction
                            WHERE NEW.auction_id = auction.id AND NEW.authenticated_id = auction.seller_id) THEN
    RAISE EXCEPTION 'A users cant bid in is own auctions.';
                        END
                        IF;
  RETURN NEW;
                        END
$BODY$
LANGUAGE plpgsql;

                        CREATE TRIGGER tr_bid_check_buyer
  BEFORE
                        INSERT OR
                        UPDATE ON bid
  FOR EACH ROW
                        EXECUTE PROCEDURE check_buyer
                        ();

                        CREATE TRIGGER tr_whishlist_check_buyer
  BEFORE
                        INSERT OR
                        UPDATE ON wishlist
  FOR EACH ROW
                        EXECUTE PROCEDURE check_buyer
                        ();

                        CREATE FUNCTION change_auction_status() RETURNS TRIGGER AS
$BODY$
                        BEGIN
                            IF EXISTS (SELECT *
                            FROM auction
                            WHERE NEW.id = auction.id) THEN
                            IF NEW.end_date = now() THEN
            NEW.status := 'Ended';
                        END
                        IF;
    END
                        IF;
	    RETURN NEW;
                        END
$BODY$
LANGUAGE plpgsql;

                        CREATE TRIGGER tr_change_auction_status
    BEFORE
                        UPDATE ON auction
        FOR EACH ROW
                        EXECUTE PROCEDURE change_auction_status
                        ();


                        -- INSERTS

                        -- Admin
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,rating,user_status)
                        VALUES
                            ('admin', 'admin', 'admin', '$2y$10$b6tIsyFblraCZ3J42OFE8eQnAC327Mp857rG67MFkcQ9JkiuxUQeq', 'admin@upauctions.com', 'true', '5', 'Good');

                        -- Users
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('magna', 'Mikayla', 'Chester', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'aliquam.eros.turpis@estvitaesodales.ca', 'false', '6266', '968-1648 Netus Avenue', '', '3', 'Good');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('luctus', 'Eric', 'Barrett', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'dictum.Phasellus@elit.net', 'false', '78634', '378-1124 In St.', '', '1', 'Banned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('eu', 'Jael', 'Garth', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'a@scelerisquesed.net', 'false', '610719', 'Ap #191-8770 Odio Street', '', '3', 'Warned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('mi', 'Shelby', 'Cedric', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'purus.mauris@at.edu', 'false', '06-709', '8839 Enim. Street', '', '2', 'Warned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('felis.', 'Sawyer', 'Jakeem', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'Fusce.mi@augue.org', 'false', '2451 CQ', 'P.O. Box 997, 2513 At, Street', '', '0', 'Banned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('tincidunt', 'Holmes', 'Allistair', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'risus.Donec.nibh@massa.com', 'false', 'EZ3Z 0WR', 'Ap #798-8485 Imperdiet Ave', '', '1', 'Warned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('Ut', 'Karyn', 'Lacey', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'tempus.eu.ligula@sociisnatoque.edu', 'false', '1543', '1709 Lacus. Avenue', '', '0', 'Good');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('inceptos', 'Tasha', 'Uma', 'ZGP97CWR6EV', 'ornare.lectus@eu.ca', 'false', '05726', '6609 Duis Rd.', '', '0', 'Good');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('vulputate,', 'Rhea', 'Reuben', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'a@magnaetipsum.edu', 'false', '46905', '4788 Vivamus Rd.', '', '0', 'Warned');
                        INSERT INTO users
                            (username,first_name,last_name,password,email,is_admin,zip_code,address,profile_pic,rating,user_status)
                        VALUES
                            ('Aliquam', 'Ivan', 'Ifeoma', '$2y$10$2LdlPTUfVeCgawKrftndBOhqtXs4Ub1nbIgJS3EUM50rN36fXyeOa', 'est.congue@Vivamussit.co.uk', 'false', '255882', '903-6415 Eu Street', '', '0', 'Warned');

                        -- 02
                        insert into category
                            (name)
                        values
                            ('ligula');
                        insert into category
                            (name)
                        values
                            ('nonummy');
                        insert into category
                            (name)
                        values
                            ('eu');
                        insert into category
                            (name)
                        values
                            ('non');
                        insert into category
                            (name)
                        values
                            ('suspendisse');
                        insert into category
                            (name)
                        values
                            ('feugiat');
                        insert into category
                            (name)
                        values
                            ('dolor');
                        insert into category
                            (name)
                        values
                            ('quis');
                        insert into category
                            (name)
                        values
                            ('luctus');
                        insert into category
                            (name)
                        values
                            ('condimentum');
                        insert into category
                            (name)
                        values
                            ('cars');

                        -- 03
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (2, 'nulla', 'consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id', 361.91, 3042.03, null, '7/21/2021', 5, 'Open', 'Visa/Mastercard', 'Portugal');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (2, 'erat quisque', 'pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis', 463.57, 1443.2, 44, '7/15/2021', 1, 'Open', 'Visa/Mastercard', 'France');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (3, 'id massa', 'amet consectetuer adipiscing elit proin risus praesent lectus vestibulum quam sapien', 481.31, 1436.73, null, '7/2/2021', 8, 'Open', 'Visa/Mastercard', 'Spain');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (4, 'in libero ut', 'faucibus orci luctus et ultrices posuere cubilia curae mauris viverra', 548.44, 1225.04, 1, '7/29/2021', 9, 'Open', 'Paypal', 'USA');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (5, 'nibh ligula nec', 'ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est', 81.31, 3134.74, 37, '7/17/2021', 5, 'Ended', 'Paypal', 'Worldwide');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (6, 'dui', 'turpis integer aliquet massa id lobortis convallis tortor risus dapibus augue vel accumsan tellus', 739.57, 2355.29, 19, '7/2/2021', 7, 'Ended', 'Paypal', 'United Kingdom');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (7, 'vulputate vitae', 'enim leo rhoncus sed vestibulum sit amet cursus id turpis integer aliquet massa id lobortis convallis tortor risus dapibus augue vel accumsan tellus nisi', 213.64, 1119.35, 36, '7/4/2021', 1, 'Open', 'MBWay', 'France');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (6, 'metus sapien ut', 'odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi', 1.0, 4349.99, null, '7/28/2021', 11, 'Ended', 'Paypal', 'Germany');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (5, 'nulla suspendisse potenti', 'convallis morbi odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus', 827.58, 2656.0, 25, '7/4/2021', 2, 'Open', 'MBWay', 'Greece');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (3, 'rutrum ac lobortis', 'at feugiat non pretium quis lectus suspendisse potenti in eleifend quam a odio in hac habitasse platea dictumst maecenas ut massa quis', 921.91, 2836.43, null, '7/1/2021', 5, 'Ended', 'Visa/Mastercard', 'Italy');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (8, 'in tempor turpis', 'turpis adipiscing lorem vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit', 137.65, 3652.55, 23, '7/18/2021', 9, 'Ended', 'Paypal', 'Brazil');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (9, 'vestibulum ante ipsum', 'in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices', 562.5, 4633.51, 43, '7/11/2021', 7, 'Ended', 'Paypal', 'China');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (10, 'vestibulum ante ipsum', 'pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi', 498.02, 2310.26, 32, '7/27/2021', 10, 'Ended', 'Paypal', 'Japan');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (5, 'ut', 'est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet', 323.41, 3363.23, null, '7/6/2021', 8, 'Ended', 'Paypal', 'Canada');
                        insert into auction
                            (seller_id, item_name, description, starting_price, current_price, shipping_cost, end_date, category_id, auction_status, payment, shipping)
                        values
                            (9, 'porta volutpat', 'vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris eget massa tempor convallis nulla neque libero convallis eget eleifend luctus ultricies eu nibh', 729.26, 1498.87, 22, '7/29/2021', 4, 'Open', 'Paypal', 'Portugal');

                        -- 04
                        insert into photo
                            (auction_id, description, path)
                        values
                            (1, 'baby yoda', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (1, 'baby yoda', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (1, 'baby yoda', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (2, 'playstation2', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (2, 'playstation2', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (2, 'playstation2', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (3, 'pikachu', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (3, 'pikachu', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (4, 'nvidia gpu', '');
                        insert into photo
                            (auction_id, description, path)
                            values
                            (4, 'nvidia gpu', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (5, null, '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (5, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (6, 'mus etiam', '');
                            insert into photo
                            (auction_id, description, path)
                        values
                            (6, 'mus etiam', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (7, 'consectetuer eget rutrum', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (8, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (9, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (10, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (11, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (12, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (13, null, '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (14, 'at nunc commodo placerat praesent', '');
                        insert into photo
                            (auction_id, description, path)
                        values
                            (15, 'gravida sem praesent id', '');

                        --05
                        insert into faq
                            (question, answer)
                        values
                            ('What is UP Auctions?', 'UP auctions is an online auction application, that allows users to auction and bid on a wide variety of goods worldwide. Our main purpose is helping people find the products they need with a safe experience and a user-friendly interface.');
                        insert into faq
                            (question, answer)
                        values
                            ('How can I create my auctions?', 'To create an auction all you need is an free account that you can create if you already have not one, and then click the Sell button right at the top.');
                        insert into faq
                            (question, answer)
                        values
                            ('How do I know if I win the auction?', 'When the time is up the winner will receive a notification to claim the prize. If it wasnt you, dont worry theres plenty of products that you can bid.');
                        
                        -- 06
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('ultricies eu nibh', 'pulvinar sed nisl nunc rhoncus dui vel sem', true, 1);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('ipsum integer a', 'id nisl venenatis lacinia aenean sit amet', false, 2);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('congue', 'ante vel ipsum praesent blandit lacinia', false, 6);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('at', 'est congue elementum in', false, 3);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('consequat morbi', 'augue a suscipit nulla elit ac nulla sed vel enim sit amet', true, 9);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('sit', 'orci mauris lacinia sapien quis', false, 6);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ('ut dolor morbi', 'dis parturient montes', true, 7);
                        insert into notification
                            (subject, description, was_read, authenticated_id)
                        values
                            ( 'tortor sollicitudin', 'amet lobortis sapien sapien non mi integer ac neque', false, 5);

                        -- 07
                        insert into report
                            (authenticated_id, user_id, title, content, report_status, date)
                        values
                            (3, 4, 'adipiscing', 'diam id ornare imperdiet sapien urna pretium', 'Pending', '6/4/2020');
                        insert into report
                            (authenticated_id, user_id, title, content, report_status, date)
                        values
                            (5, 1, 'amet cursus id turpis integer', 'elit ac nulla sed vel enim sit amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum', 'Open', '6/19/2020');
                        insert into report
                            (authenticated_id, user_id, title, content, report_status, date)
                        values
                            (2, 9, 'amet consectetuer adipiscing elit', 'feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium', 'Pending', '7/6/2020');

                        -- 08
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (6, 8, 4, null, '6/13/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (8, 9, 4, 'pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec', '7/27/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (9, 2, 1, 'vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla nunc purus phasellus', '7/26/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (9, 2, 4, 'maecenas ut massa quis augue luctus tincidunt nulla mollis molestie lorem quisque ut erat curabitur gravida nisi at nibh in hac', '6/8/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (3, 6, 2, null, '6/15/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (9, 3, 5, 'penatibus et magnis dis parturient montes nascetur ridiculus mus etiam vel augue', '7/13/2020');
                        insert into review
                            (buyer_id, seller_id, rating, comment, date)
                        values
                            (10, 6, 3, null, '7/17/2020');

                        -- 09
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (3, 10, 'turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede', '6/20/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (3, 4, 'Super omegadab', '8/10/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (7, 8, 'vulputate elementum nullam varius nulla facilisi', '6/27/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (9, 7, 'lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus', '7/2/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (4, 5, 'nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla', '6/30/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (2, 3, 'amet eros suspendisse accumsan', '7/23/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (6, 4, 'et ultrices posuere cubilia curae duis faucibus', '7/22/2020');
                        insert into user_message
                            (sender_id, receiver_id, message, date)
                        values
                            (5, 9, 'ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien', '7/10/2020');

                        -- 10
                        insert into wishlist
                            (auction_id, authenticated_id)
                        values
                            (10, 7);
                        insert into wishlist
                            (auction_id, authenticated_id)
                        values
                            (2, 7);
                        insert into wishlist
                            (auction_id, authenticated_id)
                        values
                            (3, 7);
                        insert into wishlist
                            (auction_id, authenticated_id)
                        values
                            (6, 5);
                        insert into wishlist
                            (auction_id, authenticated_id)
                        values
                            (7, 9);
