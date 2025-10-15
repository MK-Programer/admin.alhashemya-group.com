@php
    use App\Classes\User;
    $user = new User;
    $sideBarCards = $user->getSideBarCards();
    $parentCards = $sideBarCards['parent_cards'];
    $childCards = $sideBarCards['child_cards'];
@endphp

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @if($parentCards->isNotEmpty())
                    <li class="menu-title" key="t-menu">@lang('translation.menu')</li>
                @endif
                <!-- Dynamic Parent and Child Items -->
                @foreach($parentCards as $parent)
                    @php
                        $childrens = $childCards->where('parent_id', $parent->id);
                        $hasChildrens = $childrens->isNotEmpty();
                    @endphp
                    <li class="nav-item">
                        <!-- Parent Item -->
                        <a class="nav-link {{ $hasChildrens ? 'has-arrow waves-effect' : '' }}" 
                           href="{{ $hasChildrens ? '#' : route($parent->action_route) }}" 
                           @if($hasChildrens) aria-expanded="false" @endif>
                            <i class="{{ $parent->icon }}"></i>
                            <span>{{ $parent->name }}</span>
                        </a>

                        <!-- Child Items -->
                        @if($hasChildrens)
                            <ul class="sub-menu" aria-expanded="false">
                                @foreach($childrens as $child)
                                    <li>
                                        <a href="{{ route($child->action_route) }}">
                                            <i class="{{ $child->icon }}"></i>
                                            <span>{{ $child->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->