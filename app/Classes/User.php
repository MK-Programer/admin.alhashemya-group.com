<?php
namespace App\Classes;

use Auth;
use DB;
class User{

    private $authUser; 
    
    public function __construct(){
        $this->authUser = Auth::user();
    }
    
    public function getUserGroups(){
        $userGroups = DB::table('user_groups')
                        ->where('user_id', $this->authUser->id)
                        ->where('is_active', 1)
                        ->get();
        return $userGroups;
    }

    public function getUserCompanies(){
        $userGroups = $this->getUserGroups();
        $groups = DB::table('groups')
                        ->whereIn('id', $userGroups->pluck('group_id'))
                        ->get();

        $userCompanies = DB::table('companies')
                            ->select(
                                'id',
                                'name_en',
                                'name_ar',
                                'logo',
                                )
                            ->whereIn('id', $groups->pluck('company_id'))
                            ->where('is_active', 1)
                            ->get();
        return $userCompanies;
        
    }

    public function getSideBarCards(){
        $userGroups = $this->getUserGroups();
        $lang = app()->getLocale();
        $nameColumn = $lang === 'ar' ? 's.name_ar' : 's.name_en';
        $sideBarCards = DB::table('user_groups_companies_cards as ugcc')
                            ->select(
                                's.id',
                                DB::raw("$nameColumn as name"),
                                's.icon',
                                's.action_route',
                                's.sequence',
                                's.parent_id',
                            )
                            ->leftJoin('settings as s', 's.id', 'ugcc.menu_id')
                            ->leftJoin('groups as g', 'g.id', 'ugcc.group_id')
                            ->whereIn('ugcc.group_id', $userGroups->pluck('group_id'))
                            ->where('g.company_id', $this->authUser->company_id)
                            ->where('ugcc.is_active', 1)
                            ->orderBy('s.sequence', 'ASC')
                            ->distinct('s.id')
                            ->get();
                            
        // Separate the parent and child cards
        $parentCards = $sideBarCards->where('parent_id', null); // Cards with no parent_id
        $childCards = $sideBarCards->where('parent_id', '!=', null); // Cards with parent_id
        return [
            'parent_cards' => $parentCards,
            'child_cards' => $childCards,
        ];
    }
}
?>