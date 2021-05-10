<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notice;
use App\Models\User;

class SendNotice implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $notice;
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Notice $notice, User $user)
	{
		$this->notice = $notice;
		$this->user = $user;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('notice.'.$this->notice->to_user_id);
	}

	public function broadcastAs()
	{
		return 'notice.created';
	}
}
