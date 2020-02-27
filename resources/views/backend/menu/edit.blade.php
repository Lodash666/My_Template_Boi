@extends('backend.layouts.app')

@section('title', __('labels.backend.access.roles.management') . ' | ' . __('labels.backend.access.roles.create'))

@section('content')
    {{ html()->form('PUT', route('admin.menu.update',$id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.menu.management')
                        {{--                        <small class="text-muted">@lang('labels.backend.access.menu.management')</small>--}}
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.roles.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.roles.name'))
                                ->attribute('maxlength', 191)
                                ->value($data->title_th)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.menu.nameeng'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('nameeng')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.menu.nameeng'))
                                ->attribute('maxlength', 191)
                                ->value($data->title_en)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.menu.icon'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('icon')
                                ->class('form-control')
                                ->placeholder('Ex. fas fa-users')
                                ->attribute('maxlength', 191)
                                ->value($data->icon)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.roles.associated_permissions'))
                            ->class('col-md-2 form-control-label')
                            ->for('permissions') }}

                        <div class="col-md-10">
                            @if($group->count())
                                @foreach($group as $val)
                                    <div class="checkbox d-flex align-items-center">
                                            {{ html()->label(
                                                 html()->checkbox('group[]', old('group') && in_array($val->id, old('group')) ? true : false, $val->id)
                                               ->class('switch-input')
                                               ->id('permission-'.$val->id)
                                               . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                              ->class('switch switch-label switch-pill switch-primary mr-2')
                                              ->for('permission-'.$val->id) }}
                                            {{ html()->label(ucwords($val->name))->for('permission-'.$val->id) }}
                                    </div>
                                @endforeach
                            @endif
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.role.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.edit')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@section('script')
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var data = @json($role);
            for(let i =0;i<data.length;i++){
                $('#permission-'+data[i].role_id).attr('checked',true);
            }
        })
    </script>
@endsection
