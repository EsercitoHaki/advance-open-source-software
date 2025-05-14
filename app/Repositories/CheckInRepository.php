<?php 

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\CheckIn;
use Carbon\Carbon;
use App\DTOs\CheckInDTO; 
use App\Exceptions\AppException;

class CheckInRepository implements CheckInRepositoryInterface
{
    public function create(CheckInDTO|array $data): CheckIn
    {
        if ($data instanceof CheckInDTO) {
            $data = $data->toArray();
        }

        try {
            return CheckIn::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                throw new AppException('Bạn đã điểm danh hôm nay rồi!');
            }
            throw $e;
        }
    }
}