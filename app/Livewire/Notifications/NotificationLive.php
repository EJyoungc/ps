<?php

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component; use App\Services\NS;

class NotificationLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $selected;
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function open($id)
    {
        $this->selected = Notification::findOrFail($id);
        if (!$this->selected->read) {
            $this->selected->markAsRead();
            $this->loadNotifications();
        }
        $this->modal = true;
    }

    public function close()
    {
        $this->modal = false;
        $this->selected = null;
    }

    public function render()
    {
        return view('livewire.notifications.notification-live');
    }
}
