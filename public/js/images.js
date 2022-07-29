function pictureClick() {
    document.querySelector('#profilePicture').click();
}

function pictureClick1() {
    document.querySelector('#photo1').click();
}
function pictureClick2() {
    document.querySelector('#photo2').click();
}
function pictureClick3() {
    document.querySelector('#photo3').click();
}

function displayImage(e) {
    if (e.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage1(e) {
    if (e.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image1').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
function displayImage2(e) {
    if (e.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image2').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage3(e) {
    if (e.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image3').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
