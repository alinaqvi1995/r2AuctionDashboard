<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\EventImage;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageTrait;
use App\Traits\MultipleImageTrait;

class EventService
{
    use ImageTrait, MultipleImageTrait;

    public function createEvent(array $data)
    {
        $eventData = $this->prepareEventData($data);

        // Create the event
        $event = Event::create($eventData);

        // Handle additional images
        if (isset($data['additional_images'])) {
            $this->handleAdditionalImages($event, $data['additional_images']);
        }

        // Save the event ticket details
        if (isset($data['ticket_id'])) {
            $this->saveEventTickets($event, $data['ticket_id'], $data['price'], $data['quantity']);
        }

        return $event;
    }

    public function updateEvent(Event $event, array $data)
    {
        $eventData = $this->prepareEventData($data);

        // Update event attributes
        $event->update($eventData);

        // Handle additional images
        if (isset($data['additional_images'])) {
            $this->handleAdditionalImages($event, $data['additional_images']);
        }

        // Update event ticket details
        if (isset($data['ticket_id'])) {
            $this->updateEventTickets($event, $data['ticket_id'], $data['price'], $data['quantity']);
        }

        return $event;
    }

    protected function prepareEventData(array $data)
    {
        $eventData = [
            'name' => $data['name'],
            'package_id' => $data['package_id'],
            'category_id' => $data['category_id'],
            'user_id' => $data['user_id'],
            'total_no_of_tickets' => $data['total_no_of_tickets'],
            'venue' => $data['venue'],
            'address' => $data['address'],
            'description' => $data['description'] ?? null,
            'eventType' => $data['eventType'],
            'start_date' => $data['start_date'] ?? null,
            'start_time' => $data['start_time'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'end_time' => $data['end_time'] ?? null,
            'all_day' => $data['all_day'] ?? null,
            'status' => $data['status'],
            // Add other fields as needed
        ];

        // Handle dress code
        if (isset($data['dress_code'])) {
            $eventData['dress_code'] = implode(',', $data['dress_code']);
        }

        return $eventData;
    }

    protected function handleAdditionalImages(Event $event, $images)
    {
        $additionalImagePaths = $this->uploadMultipleImages($images, 'additional_images');
        foreach ($additionalImagePaths as $additionalImage) {
            EventImage::create([
                'event_id' => $event->id,
                'image_url' => $additionalImage['path'],
                'image_name' => $additionalImage['original_name'],
            ]);
        }
    }

    protected function saveEventTickets(Event $event, $ticketIds, $prices, $quantities)
    {
        foreach ($ticketIds as $key => $ticketId) {
            $eventTicketData = [
                'ticket_id' => $ticketId,
                'event_id' => $event->id,
                'price' => $prices[$key],
                'quantity' => $quantities[$key],
                'status' => 1,
            ];
            EventTicket::create($eventTicketData);
        }
    }

    protected function updateEventTickets(Event $event, $ticketIds, $prices, $quantities)
    {
        foreach ($ticketIds as $key => $ticketId) {
            $eventTicket = $event->tickets()->where('ticket_id', $ticketId)->first();
            if ($eventTicket) {
                $eventTicket->update([
                    'price' => $prices[$key],
                    'quantity' => $quantities[$key],
                ]);
            }
        }
    }
}
