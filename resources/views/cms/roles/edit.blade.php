@extends('cms.home')
@section('title')
<h2>User Management</h2>
@stop
@section('content')
<div class='main-container__content__info upload-access'>
   <div action="" id="upload" files="true">
       <div class="row">
            <div class="col-sm-12">
               <div role="tabpanel" class="modal-body__media modal-body__media--usermngt">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-tabs--settings nav-tabs--settings--usermngt" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#editrole" aria-controls="website" role="tab" data-toggle="tab">Edit Role</a>
                    </li>
                    <li role="presentation">
                        <a href="#editaccesscontrol" aria-controls="mail" role="tab" data-toggle="tab">Edit Access Control</a>
                    </li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content tab-content--settings tab-content--usermngt">

                  	{!! Form::open(array('route' => array('cms.role.modifyAccess'), 'method' => 'post')) !!}
                    {!! Form::hidden('role_id', $role->id) !!}
                    <div role="tabpanel" class="tab-pane active" id="editrole">
                       <div class="row">
                           <div class="col-sm-8">
                                <div class="form-group">
                                     {!! Form::label('role_name', 'Role Name', array('class' => 'form-title', 'for' => 'user-role')) !!}
									                   {!! Form::text('role_name', $role->role_name, array('class' => 'form-control', 'id' => 'user-role', 'placeholder' => 'Enter user role')) !!}
                                </div>
                                <div class="form-group">                                    
                                    {!! Form::label('role_description', 'Desciption', array('for' => 'user-role-desc', 'class' => 'form-title')) !!}
                                    {!! Form::textarea('role_description', $role->role_description, array('id' => 'user-role-desc', 'class' => 'form-control', 'rows' => '5')) !!}
                                </div>
                           </div>
                           
                           <div class="col-sm-3 col-sm-offset-1">
                              <h4>Status</h4>
                               <div class="main-container__content__info__options main-container__content__info__options--userrole">
                                   @if($role->role_active == 1)
                                   <div class="checkbox">
                                        <label>
                                          {!! Form::radio('role_active', 1, true) !!} Active
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                          {!! Form::radio('role_active', 0) !!} Inactive
                                        </label>
                                    </div>
                                    @else
                                    <div class="checkbox">
                                        <label>
                                          {!! Form::radio('role_active', 1) !!} Active
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                          {!! Form::radio('role_active', 0, true) !!} Inactive
                                        </label>
                                    </div>
                                    @endif
                               </div>
                            </div>
                       </div>                           
                    </div>

                    <div role="tabpanel" class="tab-pane" id="editaccesscontrol">
                        <div class="col-sm-12">
                           <div class="editaccesscontrol__title-holder clearfix">
                               <h5 class='editaccesscontrol__title editaccesscontrol__title--left'>Modules</h5>
                               <h5 class='editaccesscontrol__title'>Sub Modules</h5>
                           </div>
                            
                            <div class="editaccesscontrol__content">
                                <ul class="list-unstyled editaccesscontrol__content__modules-list">
                                    @foreach(modules() as $module)
                                       @foreach($access as $acc) 
                                            @if($module->id == $acc->module_id)
                                            <li>
                                                <label for="{!! strtolower($module->module_name) !!}">
                                                    <span>{!! ucwords(strtolower($module->module_name)) !!}</span>
                                                    {!! Form::checkbox('module_enabled' . $module->id, $acc->is_enabled, $acc->is_enabled, array('class' => 'module_checkbox', 'attr' => $module->id )); !!} 
                                                </label>
                                                <div class="sub-module_container">
                                                    <ul class="list-unstyled sub-module_list clearfix">
                                                        @foreach(submenus() as $menu)

                                                            @if($module->id == $menu->module_id)
                                                                @foreach($subAccess as $subAcc)
                                                                    @if($menu->id == $subAcc->submenu_id)
                                                                        <li> 
                                                                            <label for="{!! strtolower($module->module_name) . '_' . strtolower($menu->submenu_name) !!}">
                                                                                <span>{!! ucwords(strtolower($menu->submenu_name)) !!}</span>
                                                                                {!! Form::checkbox('sub_enabled' . $menu->id, $subAcc->is_enabled, $subAcc->is_enabled,
                                                                                                array('class' => 'module_checkbox', 'attr' => $module->id )); !!} 
                                                                            </label>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            @endif

                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            @endif
                                        @endforeach
                                    @endforeach                        
                                </ul>
                            </div>
                        </div>
                    </div>
                  </div>
                              
                  <div class="tab-footer">                      
                      {!! Form::submit('Save Changes', array('class' => 'btn btn-add pull-left')) !!}
                  </div>
                </div>
            </div>
        </div>
       {!! Form::close() !!}        	
   </div>
</div>

	@if($errors->any())

		@foreach($errors->all() as $error)
			<li>{!! $error !!}</li>
		@endforeach

	@endif

@stop
<script type="text/javascript" src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.module_checkbox').click(function(e){
      if(parseInt(this.value) == 0) {
        this.value = 1;
        var mod_attr = $(this).attr('attr');

        $('.module_checkbox').each(function(){
            if(parseInt(mod_attr) == parseInt($(this).attr('attr'))) {
              $(this).val(1);
            }
        });

      } else {
        this.value = 0;

        var mod_attr = $(this).attr('attr');

        $('.module_checkbox').each(function(){
            if(parseInt(mod_attr) == parseInt($(this).attr('attr'))) {
              $(this).val(0);
            }
        });
      }
    });
  });

</script>