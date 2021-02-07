<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Participant extends Model
{
    protected $fillable = [
        'session_id', 
        'best_turn', 
        'play_date', 
        'current_turn'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    public static function getBestTurn($session, $re_current_turn=false)
    {
        $participant = Participant::setParticipant($session, $re_current_turn) ;
        $my_best_turn = $participant->first()->best_turn;
        $global_best_turn = Participant::getGlobalBestTurn();
        
        return [
            'click' => '-', 
            'my_best_turn' => (isset($my_best_turn) && $my_best_turn > 0) ? $my_best_turn : '-', 
            'global_best_turn' => (isset($global_best_turn) && $global_best_turn > 0) ? $global_best_turn : '-', 
        ];
    }

    public static function getGlobalBestTurn() 
    {
        return Participant::select([DB::raw('min(best_turn) as best_turn')])
            ->first()->best_turn;
    }

    public static function setParticipant($session, $re_current_turn=false) 
    {
        $participant = Participant::where('session_id', $session);

        if (!$participant->count()) {
            $participant->insert([ // add new
                'session_id' => $session,
                'play_date' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $update = [  
                'play_date' => date('Y-m-d H:i:s'),
            ];

            if ($re_current_turn)
                $update['current_turn'] = null;

            $participant->update($update); // update
        }

        return $participant;
    }

}
