<div class="position-relative">
    <span wire:click="toggleNotifications">
        <i class="fa fa-bell notification-bell" aria-hidden="true"></i> 
        @if($unreadCount > 0)
        <span class="btn__badge pulse-button">{{ $unreadCount}}</span> 
        @endif
    </span>
    @if($showNotifications)
        <ul class="list-group position-absolute notification-list w300">
            @foreach ($notificationsList as $item)
                <li class="list-group-item {{ $item->read_at ? '':'bg-blue pointer' }}" @if(!$item->read_at) 
                    title="Mark as read" wire:click="markRead({{ $item->id }})" @endif>{{ $item->details->title }}
                    <p ><small>{{ $item->created_at }}</small></p>
                </li>
            @endforeach
        </ul>
    @endif
</div>

