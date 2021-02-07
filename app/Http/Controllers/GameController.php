<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Participant;
use App\Repositories\CookieRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function reset(Request $request)
    {
        if (!$session = CookieRepository::getCookie('user_token')) {
            $session = CookieRepository::setCookie('user_token', CookieRepository::generateToken());
        }
        
        $turns = Participant::getBestTurn($session, true); // get global best and my best
        $cards = Card::resetBoard($session);
        
        return response()->json(compact('turns', 'cards'));
    }

    public function flip(Request $request)
    {
        $card_id = $request->card_id;
        $session = CookieRepository::getCookie('user_token');
        $participant_model = Participant::where('session_id', $session);

        if (!$participant = $participant_model->first())
            return response()->json(false);

        if (!$card = Card::getById($session, $card_id)) 
            return response()->json(false);

        $is_complete = false;
        $current_turn = ($participant->current_turn + 1);

        // update current turn ++
        if ($participant_model->update([ 
            'current_turn' => $current_turn,
        ])) {
            // update card status: flipped
            if ($card->status != Card::FOUND && $card->updateStatus($session, $card_id, Card::FLIPPED)) {
                $card->status = Card::FLIPPED;

                // get flipped card
                $cards = $card->getByStatus($session, Card::FLIPPED);
                $list_card = $cards->get()->toArray();

                // when has 2 'flipped', then check matched 
                if ($cards->count() == 2) {
                    if (isset($list_card[0]) && isset($list_card[1]))
                        $this->matchingCard($card, $session, $list_card[0], $list_card[1]);
                } 
            }
        }
        
        // if count 'found' == 12 
        $found_cards = $card->getByStatus($session, Card::FOUND);
        if ($found_cards->count() == 12) {
            $best_turn = (isset($participant->best_turn)) ? min($participant->best_turn, $current_turn) : $current_turn;
            $participant_model->update([ 
                'best_turn' => $best_turn, // set new best turn
                'current_turn' => 0,       // refresh current turn
            ]);

            $is_complete = true; // complete board
        }

        return response()->json(compact('card', 'current_turn', 'is_complete'));
    }

    private function matchingCard(&$current_card, $session, $card1, $card2=null) 
    {
        // if card matched, update card status to 'found' and set card state to found
        if (is_matched($card1['card_value'], $card2['card_value'])) {
            $current_card->updateStatus($session, [$card1['card_id'], $card2['card_id']], Card::FOUND);
            $current_card->status = Card::FOUND;

        // if card un-matched, remove status
        } else {
            $current_card->updateStatus($session, [$card1['card_id'], $card2['card_id']], null);
            $current_card->status = null;
        }
    }
}
