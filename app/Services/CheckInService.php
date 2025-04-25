<?php

namespace App\Services;

use App\Repositories\CheckInRepository;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;

class CheckInService
{
    protected CheckInRepository $checkInRepository;

    public function __construct(CheckInRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function checkIn($user): array
    {
        if ($this->checkInRepository->hasCheckedInToday($user->id)) {
            throw new AppException('Bạn đã điểm danh hôm nay rồi!');
        }

        return DB::transaction(function () use ($user) {
            // Ghi nhận điểm danh
            $this->checkInRepository->createCheckIn($user->id, 10);

            // Cộng xu
            $user->increment('coins', 10);

            // Kiểm tra điểm danh liên tiếp
            $lastCheckIn = $this->checkInRepository->getLastCheckInBeforeToday($user->id);
            $yesterday = now()->subDay()->toDateString();

            if ($lastCheckIn && $lastCheckIn->check_in_date == $yesterday) {
                $user->increment('current_streak');
            } else {
                $user->update(['current_streak' => 1]);
            }

            // Cập nhật chuỗi dài nhất nếu cần
            if ($user->current_streak > $user->longest_streak) {
                $user->update(['longest_streak' => $user->current_streak]);
            }

            return [
                'message' => 'Điểm danh thành công!',
                'coins'   => $user->coins,
                'streak'  => $user->current_streak,
            ];
        });
    }
}
