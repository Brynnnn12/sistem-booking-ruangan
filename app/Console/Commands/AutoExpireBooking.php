<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class AutoExpireBooking extends Command
{
    // Nama command yang dipanggil robot/cron
    protected $signature = 'booking:expire';

    // Deskripsi
    protected $description = 'Ubah status booking pending yang lewat jam mulai jadi rejected';

    public function handle()
    {
        $this->info('Sedang mengecek booking kadaluarsa...');

        // ---------------------------------------------------------
        // CLEAN CODE VERSION
        // ---------------------------------------------------------
        // Kita gak perlu tulis logic "where date < now" yang ribet disini.
        // Kita panggil Scope yang sudah kita buat di Model.

        $affected = Booking::pending()          // Panggil scopePending()
            ->pastStartTime()                   // Panggil scopePastStartTime()
            ->update([
                'status' => Booking::STATUS_REJECTED  // Pakai Constant biar aman
            ]);

        // ---------------------------------------------------------

        // Feedback ke Terminal
        if ($affected > 0) {
            $this->info("Berhasil: Ada {$affected} booking yang di-rejected-kan.");
        } else {
            $this->comment('Aman: Tidak ada booking yang kadaluarsa.');
        }
    }
}
