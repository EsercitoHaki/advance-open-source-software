<?php

namespace App\DTOs;

use App\Models\MascotPic;

class MascotPicDTO
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

    public static function fromModel(MascotPic $mascotPic): self
    {
        return new self(
            pic_id: $mascotPic->pic_id,
            pic_name: $mascotPic->pic_name,
            pic_url: $mascotPic->pic_url,
        );
    }

}
