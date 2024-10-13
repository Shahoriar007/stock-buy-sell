@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="p-0 card-body">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Slug')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Created')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                    <tr>

                                        <td>
                                            <span class="fw-bold">{{ @$blog->title }}</span>

                                        </td>

                                        <td>
                                            {{ $blog->slug }}
                                        </td>

                                        <td>{{ $blog->status_text }}</td>
                                        <td>
                                            {{ showDateTime($blog->created_at) }} <br>
                                            {{ diffForHumans($blog->created_at) }}
                                        </td>
                                    <td>
                                        <div class="button--group">
                                            <button type="button" class="btn btn-sm btn-outline--primary editBtn">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>

                                            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                data-question="@lang('Are you sure to delete this')?"
                                                data-action="{{ route('admin.blog.delete', $blog->id) }}">
                                                <i class="la la-eye-slash"></i> @lang('Delete')
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($blogs->hasPages())
                    <div class="py-4 card-footer">
                        {{ paginateLinks($blogs) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>


    </div>

    <div id="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row justify-content-center align-items-center">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Title')</label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title') }}" required>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Slug')</label>
                                        <input type="text" class="form-control" name="slug"
                                            value="{{ old('slug') }}" required>
                                    </div>


                                    <div class="form-group col-lg-12">
                                        <label>@lang('Content')</label>
                                        <textarea class="form-control" name="content" id="editor">{{ old('content') }}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label>@lang('Status')</label>
                                        <select class="form-control" name="status">
                                            <option value="">{{ __('Select Status') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_DRAFT }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_DRAFT ? 'selected' : '' }}>
                                                {{ __('Draft') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_PUBLISHED }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_PUBLISHED ? 'selected' : '' }}>
                                                {{ __('Published') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_ARCHIVED }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_ARCHIVED ? 'selected' : '' }}>
                                                {{ __('Archived') }}</option>
                                        </select>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45 ">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row justify-content-center align-items-center">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Title')</label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title') }}" required>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Slug')</label>
                                        <input type="text" class="form-control" name="slug"
                                            value="{{ old('slug') }}" required>
                                    </div>


                                    <div class="form-group col-lg-12">
                                        <label>@lang('Content')</label>
                                        <textarea class="form-control" name="content" id="editor">{{ old('content') }}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label>@lang('Status')</label>
                                        <select class="form-control" name="status">
                                            <option value="">{{ __('Select Status') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_DRAFT }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_DRAFT ? 'selected' : '' }}>
                                                {{ __('Draft') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_PUBLISHED }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_PUBLISHED ? 'selected' : '' }}>
                                                {{ __('Published') }}</option>
                                            <option value="{{ \App\Models\Blog::STATUS_ARCHIVED }}"
                                                {{ old('status') == \App\Models\Blog::STATUS_ARCHIVED ? 'selected' : '' }}>
                                                {{ __('Archived') }}</option>
                                        </select>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45 ">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@push('breadcrumb-plugins')
    <div class="flex-wrap gap-2 d-flex justify-content-between">
        <x-search-form placeholder="Title...." />

        <button type="button" class="btn btn-outline--primary addBtn ">
            <i class="las la-plus"></i>@lang('Create New')
        </button>
    </div>
@endpush

@push('script')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    <script>
        "use strict";
        (function($) {
            let modal = $('#modal');
            // let editModal = $('#editModal');


            $('.addBtn').on('click', function() {

                modal.find('.modal-title').text("@lang('New Blog')");
                $(modal).modal('show');
            });

            $('.editBtn').on('click', function(e) {
                let action = `{{ route('admin.blog.edit', ':id') }}`;


                $(modal).modal('show');
            });

        })(jQuery);
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all elements with the class confirmationBtn
        let confirmationButtons = document.querySelectorAll('.confirmationBtn');

        confirmationButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                // Get the data attributes from the button
                let question = button.getAttribute('data-question');
                let action = button.getAttribute('data-action');

                // Show confirmation dialog (this could be a custom modal, here is an example using window.confirm)
                if (confirm(question)) {
                    // Create a form dynamically to send the DELETE request
                    let form = document.createElement('form');
                    form.setAttribute('method', 'POST');
                    form.setAttribute('action', action);

                    // Add CSRF token input
                    let csrfInput = document.createElement('input');
                    csrfInput.setAttribute('type', 'hidden');
                    csrfInput.setAttribute('name', '_token');
                    csrfInput.setAttribute('value', '{{ csrf_token() }}');
                    form.appendChild(csrfInput);

                    // Add DELETE method input
                    let methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    methodInput.setAttribute('value', 'DELETE');
                    form.appendChild(methodInput);

                    // Append the form to the body and submit it
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

@endpush

@push('style')
    <style>
        .modal-loader {
            position: absolute;
            left: 0;
            top: 0;
            content: "";
            display: none;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: #ffffffc7;
        }

        .modal-loader .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@endpush
