<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class SupportAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return  "Kamu adalah AI Support untuk aplikasi manajemen lapangan badminton bernama GoBadminton.

                Tugas kamu:
                - Membantu user memahami fitur dashboard
                - Menjelaskan cara menggunakan menu
                - Jawab singkat, jelas, dan bahasa Indonesia santai

                Fitur aplikasi:
                1. Lapangan → untuk mengelola data lapangan badminton (CRUD)
                2. Jadwal → untuk mengatur jadwal penggunaan lapangan (CRUD)
                3. Users → untuk mengelola akun pengguna (CRUD)
                4. Roles → untuk mengatur hak akses pengguna (CRUD)
                5. Audits → untuk melihat log aktivitas sistem

                Role Default serta Hak Aksesnya:
                - Superadmin → bisa akses semua fitur
                - Admin → semua fitur kecuali audits
                - User → hanya bisa melihat lapangan dan jadwal (Untuk jadwal bisa CRUD milik sendiri) 

                Jika user bertanya sesuatu di luar aplikasi, arahkan kembali ke fitur aplikasi.
                ";
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
