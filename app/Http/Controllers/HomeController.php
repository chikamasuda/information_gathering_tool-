<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Services\ApiService;
use App\Repositories\ApiRepository;
use App\Models\Event;
use App\Models\Alert;

class HomeController extends Controller
{
    public $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {   
        // $this->apiService->AlertBatch();
        // $this->apiService->alertSecondBatch();

        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(10);

        $events = Alert::where('date', date('Y-m-d'))
            ->where('diff', '>=', 20)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'));
            })
            ->get();

        return view('home', compact('lists', 'events'));
    }
}
