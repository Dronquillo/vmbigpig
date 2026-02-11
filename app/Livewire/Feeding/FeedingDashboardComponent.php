<?PHP

namespace App\Livewire\Feeding;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\lots as Lot;
use App\Models\Activovivo;
use App\Models\FeedFormula;
use App\Models\feeding_plans as FeedingPlan;
use App\Models\feeding_events as FeedingEvent;
use App\Models\weight_records as WeightRecord;
use App\Models\HealthCheck;
use App\Models\Alert;
use App\Models\BirthEvent;

#[Title('Dashboard de Alimentación')]
class FeedingDashboardComponent extends Component
{
    public $lot_id = null;
    public $mostrarDashboard = false;

    //public $animals = []; 
    public $plans = []; 
    public $events = []; 
    public $weights = []; 
    public $checks = []; 
    public $alerts = []; 
    public $births = []; 
    
    public function cargarInformacion() 
    { 
        if ($this->lot_id) { 
            $animals = Activovivo::where('lot_id', $this->lot_id)->get(); 
            $this->plans = FeedingPlan::with('formula')->where('lot_id', $this->lot_id)->get(); 
            $this->events = FeedingEvent::whereHas('plan', fn($q) => $q->where('lot_id', $this->lot_id))->get(); 
            $this->weights = WeightRecord::whereIn('activovivo_id', $animals->pluck('id'))->get(); 
            $this->checks = HealthCheck::whereIn('activovivo_id', $animals->pluck('id'))->get(); 
            $this->alerts = Alert::whereIn('activovivo_id', $animals->pluck('id'))->get(); 
            $this->births = BirthEvent::whereIn('activovivo_id', $animals->pluck('id'))->get(); 
            $this->mostrarDashboard = true; 
        } 
    }


    public function render()
    {
        $lots = Lot::orderBy('code')->get();
        // $animals = $this->lot_id ? Activovivo::where('lot_id',$this->lot_id)->get() : collect();
        // $plans = $this->lot_id ? FeedingPlan::with('formula')->where('lot_id',$this->lot_id)->get() : collect();
        // $events = $this->lot_id ? FeedingEvent::whereHas('plan', fn($q)=>$q->where('lot_id',$this->lot_id))->get() : collect();
        // $weights = $this->lot_id ? WeightRecord::whereIn('activovivo_id',$animals->pluck('id'))->get() : collect();
        // $checks = $this->lot_id ? HealthCheck::whereIn('activovivo_id',$animals->pluck('id'))->get() : collect();
        // $alerts = $this->lot_id ? Alert::whereIn('activovivo_id',$animals->pluck('id'))->get() : collect();
        // $births = $this->lot_id ? BirthEvent::whereIn('activovivo_id',$animals->pluck('id'))->get() : collect();

        return view('livewire.feeding.dashboard', compact('lots'));

        //,'animals','plans','events','weights','checks','alerts','births'

    }
    
}
