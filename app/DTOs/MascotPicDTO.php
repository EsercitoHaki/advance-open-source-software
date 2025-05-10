<?php
namespace App\DTO;

class MascotPicResponse
{
    public int $pic_id;
    public string $pic_name;
    public string $pic_url;

    public function __construct(array $data)
    {
        $this->pic_id = $data['pic_id'];
        $this->pic_name = $data['pic_name'];
        $this->pic_url = $data['pic_url'];
    }
}
