<?php

namespace SunAsterisk\Chatwork\Endpoints;

class Rooms extends Endpoint
{
    /**
     * Get user rooms list
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#GET-rooms
     */
    public function list()
    {
        return $this->api->get('rooms');
    }

    /**
     * Create new room
     *
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#POST-rooms
     */
    public function create(array $params)
    {
        $room = array_merge($params, [
            'members_admin_ids' => implode(',', $params['members_admin_ids'] ?? []),
            'members_member_ids' => implode(',', $params['members_member_ids'] ?? []),
            'members_readonly_ids' => implode(',', $params['members_readonly_ids'] ?? []),
        ]);

        return $this->api->post('rooms', $room);
    }

    /**
     * Update room members
     * @param  int $roomId
     * @param  array $membersAdminIds
     * @param  array $params
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#PUT-rooms-room_id-members
     */
    public function updateRoomMembers($roomId, $membersAdminIds = [], $params = [])
    {
        $params = array_merge(
            ['members_admin_ids' => $membersAdminIds,
            ], $params);
        if (!empty($params['members_admin_ids'])) {
            $params['members_admin_ids'] = implode(',', $params['members_admin_ids']);
        }
        if (!empty($params['members_member_ids'])) {
            $params['members_member_ids'] = implode(',', $params['members_member_ids']);
        }
        if (!empty($params['members_readonly_ids'])) {
            $params['members_readonly_ids'] = implode(',', $params['members_readonly_ids']);
        }

        return $this->api->put('rooms/'.$roomId, $params);
    }

    /**
     * Get file info endpoint
     * @param  int $roomId
     * @param  int $fileId
     * @param  bool $createDownloadUrl
     * @return array
     *
     * @see http://developer.chatwork.com/vi/endpoint_rooms.html#GET-rooms-room_id-files-file_id
     */
    public function getRoomFileById($roomId, $fileId, $createDownloadUrl = false)
    {
        return $this->api->get(
            sprintf('rooms/%d/files/%d', $roomId, $fileId),
            ['create_download_url' => $createDownloadUrl ? 1 : 0]
        );
    }
}
