<?php

namespace SunAsterisk\Chatwork\Endpoints;

class Rooms extends Endpoint
{
    /**
     * Get user rooms list
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#GET-rooms
     */
    public function getRooms()
    {
        return $this->api->get('rooms');
    }

    /**
     * Create new room
     * @param  string $name
     * @param  array $membersAdminIds
     * @param  array $params
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#POST-rooms
     */
    public function createRoom($name, $membersAdminIds = [], $params = [])
    {
        $params['members_admin_ids'] = $membersAdminIds;
        $params['name'] = $name;

        $params['members_admin_ids'] = implode(',', $params['members_admin_ids']);
        if (!empty($params['members_member_ids'])) {
            $params['members_member_ids'] = implode(',', $params['members_member_ids']);
        }
        if (!empty($params['members_readonly_ids'])) {
            $params['members_readonly_ids'] = implode(',', $params['members_readonly_ids']);
        }

        return $this->api->post('rooms', $params);
    }

    /**
     * Get room information
     * @param  int $roomId
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#GET-rooms-room_id
     */
    public function getRoomById($roomId)
    {
        return $this->api->get('rooms/'.$roomId);
    }

    /**
     * Update room information
     * @param  int $roomId
     * @param  array $params
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#PUT-rooms-room_id
     */
    public function updateRoomInfo($roomId, $params = [])
    {
        return $this->api->put('rooms/'.$roomId, $params);
    }

    /**
     * Leave/Delete Group chat
     * @param  int $roomId
     * @param  int $type
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#DELETE-rooms-room_id
     */
    public function deleteLeaveRoom($roomId, $type)
    {
        return $this->api->delete('rooms/' . $roomId, ['action_type' => $type]);
    }

    /**
     * Get all member of a room
     * @param  int $roomId
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#GET-rooms-room_id-members
     */
    public function getRoomMembersById($roomId)
    {
        return $this->api->get(sprintf('rooms/%d/members', $roomId));
    }
}
