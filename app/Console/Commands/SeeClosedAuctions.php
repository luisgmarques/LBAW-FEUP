<?php

namespace App\Console\Commands;

use App\Auction;
use App\Bid;
use App\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SeeClosedAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:seeClosedAuctions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $auctions = Auction::whereDate('end_date', '<', Carbon::now())->get();

        for($i = 0; $i<$auctions->count(); $i++)
        {
            $user = User::where('id', '=', $auctions[$i]->seller_id)->pluck('id');

            $notification = new Notification();
            $notification->subject = "Closed Auction";
            $notification->description = "Your auction closed. See the winner!";
            $notification->was_read = false;
            $notification->authenticated_id = $user[0];
            $notification->save();

            $bid = Bid::where('auction_id', '=', $auctions[$i]->id)
                ->orderBy('date', 'desc')->get()->last();

            if ($bid == null)
            {
                $notification = new Notification();
                $notification->subject = "Closed Auction";
                $notification->description = "No one has won!";
                $notification->was_read = false;
                $notification->authenticated_id = $user[0];
                $notification->save();
            }
            else{
                $guy = $bid->authenticated_id;

                $notification = new Notification();
                $notification->subject = "Won Auction";
                $notification->description = "You are the winner!";
                $notification->was_read = false;
                $notification->authenticated_id = $guy;
                $notification->save();
            }

            $auctions[$i]->update([
                'auction_status' => 'Ended',
            ]);

        }
    }
}
