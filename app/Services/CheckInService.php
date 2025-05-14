<?php

namespace App\Services;

use App\DTOs\CheckInDTO;
use App\Models\User;
use App\Exceptions\AppException;
use App\Repositories\CheckInRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckInService implements CheckInServiceInterface
{
    protected $checkInRepository;

    public function __construct(CheckInRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function checkIn(User $user): CheckInDTO
    {
        if (!$user) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $role = DB::table('roles')->where('role_id', $user->role_id)->value('role_name');
        if ($role !== 'student') {
            throw new AppException('Chỉ tài khoản student mới có thể điểm danh!');
        }

        return DB::transaction(function () use ($user) {
            $coins = 10;
        
            // Ghi nhận điểm danh
            $checkIn = $this->checkInRepository->create(
                new CheckInDTO($user->user_id, Carbon::now('Asia/Ho_Chi_Minh')->toDateString(), $coins)
            );
        
            // Cộng xu vào user
            $user->increment('coins', $coins);
            $user->refresh(); // lấy lại dữ liệu mới sau khi update
        
            return [
                'checkin_date' => $checkIn->checkin_date,
                'coins_earned' => $checkIn->coins_earned,
                'total_coins' => $user->coins, 
            ];
        });
    }

    public function getCheckInHistory(User $user): array
    {
        if (!$user) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $checkInHistory = $user->checkins()->orderBy('checkin_date', 'desc')->get();

        if ($checkInHistory->isEmpty()) {
            throw new AppException('Không có lịch sử điểm danh.');
        }

        return $checkInHistory->map(fn($checkin) => CheckInDTO::fromModel($checkin))->toArray();
    }

}
