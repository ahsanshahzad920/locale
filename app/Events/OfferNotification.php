<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OfferNotification implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $url;

  public function __construct($url)
  {
      $this->url = $url;
  }

  public function broadcastOn()
  {
      return ['notification-channel'];
  }

  public function broadcastAs()
  {
      return 'notification-event';
  }
}