<?php

namespace Biblioteca\Console\Commands;

use Biblioteca\Ejemplar;
use Biblioteca\Reserva;
use Illuminate\Console\Command;

class CancelarReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancelar:reserva';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancelar las reservas por vencimiento de términos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ayer = date("Y-m-d H:i:s", strtotime('-1 days')); // Si desea cambiar a las reservas que lleven más de 3 horas digitar -3 hours

        $reservas = Reserva::where('estado', 'Reservado')
            ->whereDate('created_at','<=', $ayer)->get();

        if ($reservas) {
            foreach ($reservas as $reserva) {

                $reserva->estado = 'Vencido';
                $reserva->save();

                $ejemplar = Ejemplar::find($reserva->ejemplar_id);
                $ejemplar->estado = 'Disponible';
                $ejemplar->save();
            }
        }
    }
}
