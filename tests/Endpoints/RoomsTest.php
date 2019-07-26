<?php

use SunAsterisk\Chatwork\Endpoints\Rooms;

class RoomsTest extends TestCase
{
    public function testGetRooms()
    {
        $response = $this->getMockResponse('rooms/getRooms');

        /** @var Chatwork $api */

        $api = $this->getAPIMock();
        $api = m::mock(Chatwork::class);

        $api->shouldReceive('get')->with('rooms')->andReturns($response);

        $rooms = new Rooms($api);

        $this->assertEquals($response, $rooms->list());
    }

    public function testCreateRoom()
    {
        $response = [
            'room_ids' => [1234],
        ];

        /** @var Chatwork $api */
        $api = $this->getAPIMock();
        $api->shouldReceive('post')->with('rooms', [
            'name' => 'a room',
            'members_admin_ids' => '1,2,3',
            'members_member_ids' => '4,5',
            'members_readonly_ids' => '',
        ])->andReturns($response);

        $newRoom = new Rooms($api);
        $this->assertEquals($response, $newRoom->create([
            'name' => 'a room',
            'members_admin_ids' => [1, 2, 3],
            'members_member_ids' => [4, 5],
        ]));
    }

    public function testUpdateRoomMembers()
    {
        $responses = $this->getMockResponse('rooms/updateRoomMembers');
        $roomId = $responses['roomId'];
        $params = $responses['params'];
        $membersAdminIds = $responses['membersAdminIds'];
        $params1 = $responses['params1'];
        $response = $responses['update'];

        /** @var Chatwork $api */
        $api = m::mock(Chatwork::class);
        $api->shouldReceive('put')->with('rooms/'.$roomId, $params1)->andReturns($response);

        $updateRoom = new Rooms($api);
        $this->assertEquals($response, $updateRoom->updateRoomMembers($roomId, $membersAdminIds, $params));
    }

    public function testGetRoomFileById()
    {
        $responses = $this->getMockResponse('rooms/getRoomFileById');
        $room_id = $responses['roomId'];
        $file_id = $responses['fileId'];
        $response = $responses['fileInfo'];

        /** @var Chatwork $api */
        $api = m::mock(Chatwork::class);
        $api->shouldReceive('get')
            ->with(sprintf('rooms/%d/files/%d', $room_id, $file_id), ['create_download_url' => 0])
            ->andReturns($response);

        $roomInfo = new Rooms($api);

        $this->assertEquals($response, $roomInfo->getRoomFileById($room_id, $file_id));
    }
}
