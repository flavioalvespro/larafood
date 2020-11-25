<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $profile, $plan;

    public function __construct(Profile $profile, Plan $plan)
    {
        $this->profile = $profile;
        $this->plan = $plan;
    }

    public function plans($idProfile)
    {
        $profile = $this->profile->find($idProfile);

        if (!$profile){
            return redirect()->back();
        }

        $plans = $profile->plans()->paginate();

        return view('admin.pages.profiles.plans.plans', compact('profile', 'plans'));
    }

    public function profiles($idPlan)
    {
        $plan = $this->plan->find($idPlan);

        if (!$plan){
            return redirect()->back();
        }

        $profiles = $plan->profiles()->paginate();

        return view('admin.pages.plans.profiles.profiles', compact('profiles', 'plan'));
    }

    public function plansAvailable(Request $request, $idProfile)
    {
        if(!$profile = $this->profile->find($idProfile)){
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $plans = $profile->plansAvailable($request->filter);

        return view('admin.pages.profiles.plans.available', compact('profile', 'plans', 'filters'));
    }

    public function profilesAvailable(Request $request, $idPlan)
    {
        if(!$plan = $this->plan->find($idPlan)){
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $profiles = $plan->profilesAvailable($request->filter);

        return view('admin.pages.plans.profiles.available', compact('plan', 'profiles', 'filters'));
    }

    public function attachPlansProfile(Request $request, $idProfile)
    {
        if(!$profile = $this->profile->find($idProfile)){
            return redirect()->back();
        }

        if(!$request->plans || count($request->plans) == 0){
            return redirect()->back()->with('message', 'Precisa escolher pelo menos uma permissão');
        }

        $profile->plans()->attach($request->plans);

        return redirect()->route('profiles.plans', $profile->id);
    }

    public function attachProfilesPlan(Request $request, $idPlan)
    {
        if(!$plan = $this->plan->find($idPlan)){
            return redirect()->back();
        }

        if(!$request->profiles || count($request->profiles) == 0){
            return redirect()->back()->with('message', 'Precisa escolher pelo menos um perfil');
        }

        $plan->profiles()->attach($request->profiles);

        return redirect()->route('plans.profiles', $plan->id);
    }

    public function detachPlanProfile($idProfile, $idPlan)
    {
        $profile = $this->profile->find($idProfile);
        $plan = $this->plan->find($idPlan);

        if(!$profile || !$plan){
            return redirect()->back();
        }

        $profile->plans()->detach($plan);

        return redirect()->route('profiles.plans', $profile->id);
    }

    public function detachProfilePlan($idPlan, $idProfile)
    {
        $plan = $this->plan->find($idPlan);
        $profile = $this->profile->find($idProfile);
    
        if(!$profile || !$plan){
            return redirect()->back();
        }

        $plan->profiles()->detach($profile);

        return redirect()->route('plans.profiles', $plan->id);
    }

}
