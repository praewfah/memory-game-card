<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'session_id', 
        'card_id', 
        'card_value', 
        'status'
    ];

    public const FIELDS = [1,2,3,4,5,6,1,2,3,4,5,6];
    public const FLIPPED = 'flipped';
    public const FOUND = 'found';

    public static function getById($session, $card_id) 
    {
        return Card::where('session_id', $session)
            ->where('card_id', $card_id)
            ->first();
    }

    public static function getByStatus($session, $status) 
    {
        return Card::where('session_id', $session)
            ->where('status', $status);
    }

    public static function updateStatus($session, $card_id, $status=null) 
    {   
        return $query = Card::where('session_id', $session)
            ->where(function($query) use ($card_id){
                if (is_array($card_id)) {
                    $query->whereIn('card_id', $card_id);
                } else {
                    $query->where('card_id', $card_id);
                }
            })
            ->update([ 
                'status' => isset($status) ? (string)$status : null,
            ]);
    }

    public static function resetBoard($session)
    {
        // clear card
        Card::where('session_id', $session)->delete(); 
        
        // insert new card collection 
        $cards = Card::randomCards();
        if(Card::insert(collect($cards)->map(function ($item, $key) use ($session) {
            return [
                'session_id' => $session, 
                'card_id' => $key, 
                'card_value' => $item, 
                'status'=>null
            ];
        })->toArray())) {
            // render card with id
            return collect($cards)->map(function ($item, $key) use ($session) {
                return [
                    'card_id' => $key, 
                    'flipped' => false, 
                    'found' => false
                ];
            })->toArray();
        }
        
        return false;
    }

    public static function randomCards()
    {
        $random_cards = [];
        $num = Card::FIELDS;

        foreach($num as $key => $val) {
            $rand_keys = array_rand($num, 1);
            $random_cards[($key+1)] = $num[$rand_keys];
            unset($num[$rand_keys]);
        }

        return ($random_cards);
    }

}
