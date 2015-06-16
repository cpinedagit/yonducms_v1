@extends('cms.home')

@section('title')
<h2>
    Menu Management
</h2>
@stop

@section('content')

<div class='main-container__content__info'>

    <div class="row">            

        <div class="col-sm-6">

            <div class="panel panel-default panel--custom">
                <div class="panel-heading"><h4>Menu Structure</h4></div>
                <div class="panel-body">
                    <div class="panel-body__instruction">
                        Drag each item into the order you prefer, or add a new menu
                    </div>
                    <div class="form-inline panel-body__nav-position">
                        <div class="form-group">
                            <label for="position-nav">Select Position of Navigaiton</label>
                            <select class="form-control"  name="menuposition" id="menuposition">
                                @if(isset($objMenuPosition))
                                @foreach($objMenuPosition as $objmenupos)
                                <option value="{{ $objmenupos->id}}" {{ ($objmenupos->is_selected == 1) ? 'selected' : '' }}>{{ $objmenupos->position }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="cf nestable-lists">
                        <div class="dd" id="nestable">
                            <ol class="dd-list" id="list-cont">

                                @if(isset($objMenu))
                                @foreach($objMenu as $menu)
                                <?php $url_origin = ($menu->page_id == 0) ? 'external' : 'slug'; ?>
                                <li id="idli_{{ $menu->menu_id }}" class="dd-item" data-menu_id="{{ $menu->menu_id }}" data-page_id="{{ $menu->page_id }}" data-parent_id="{{ $menu->parent_id }}" data-label="{{ $menu->label }}" data-url="{{ $menu->slug ? $menu->slug : $menu->external_link  }}" data-url_origin="{{ $url_origin }}">
                                    <div class="dd-handle" id="target_{{ $menu->menu_id }}">{{ $menu->label }} </div>

                                    {!! getSubMenu($menu->menu_id) !!}

                                    <button class='circle btn--remove-menu delete-item' onclick="delThis({{ $menu->menu_id }})"></button>
                                </li>

                                @endforeach
                                @endif

                            </ol>
                        </div>
                    </div>

                    <form id="structure_menu" name="structure_menu">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="nestable-output" id="nestable-output">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel--custom main-container__content__info__properties">         

                        <div class="panel-heading"><h4>Properties</h4></div>
                        <div class="panel-body">
                            <div class="panel-body__instruction">
                                Click on a menu item to edit the properties
                            </div>
                            <div class="panel-body__textbox-holder">

                                <form id="menu_form" name="menu_form">

                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    <input type="hidden" name="menu_id" class="form-control"  id="menu_id">
                                    <input type="text"  name="menu_label" class="form-control" placeholder="Title" readonly="true" id="menu_label">
                                    <input type="text" class="form-control" placeholder="Link" readonly name='menu-link' id='menu-link'>                                    
                                </form>
                                <br>

                                <button id="saveMenuChanges" disabled="true" class="btn btn-add">Apply Changes</button>
                                <button class="btn btn-warning" disabled="true" id='clear_btn' onclick="autoClear()">Cancel</button>
                            </div>

                        </div>

                    </div>


                </div>

            </div>

            <div class="row">
                <div class="main-container__content__info__tabpanel col-sm-8 center-block">
                    <div role="tabpanel" class="center-block">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#pages" aria-controls="home" role="tab" data-toggle="tab">Pages</a></li>
                            <li role="presentation"><a href="#links" aria-controls="profile" role="tab" data-toggle="tab">Links</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane tab-pages active" id="pages">
                                <input type="text" class='form-control' id="livesearch-input" placeholder="Search page">
                                <div class="page-list-holder">
                                    <ol class="list-unstyled" id="page-table">
                                        <div class="checkbox" id="livesearch_result">
                                            @if(isset($objPage))
                                            @foreach($objPage as $pages)
                                            <li>
                                                <label>
                                                    <input type="checkbox" class="check_pages" name="pages[]" value="{{ $pages->title }}" data-page_id="{{ $pages->id }}" data-label="{{ $pages->title }}" data-url="{{ $pages->slug }}"> {{ $pages->title }}
                                                </label>
                                            </li>

                                            @endforeach
                                            @endif
                                        </div>

                                    </ol>
                                </div>
                                <div class="btn-holder">
                                    <button class="btn btn-add">
                                        <input type="checkbox" name="my-checkbox" id="selectUs"><label for='selectUs'>Check All</label></button>
                                    <button class="btn btn-add" id="addPagestonavi"  disabled="true">Add to Navigation</button>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="links">
                                <div class="textbox-holder">
                                    <input type="text" class="form-control" name="external_label" id="external_label" placeholder="Navigation Label">
                                    <input type="text" class="form-control" name="external_link" id="external_link" placeholder="External Link">
                                </div>

                                <button class="btn btn-add pull-right pull-bottom-right" disabled="true"  id="addExternalLink">Add to Navigation</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop