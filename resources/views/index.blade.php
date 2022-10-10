@extends('master')
@section('content')
@section('title') | Posts Listing @endsection

<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-9 col-12">
        <h3 class="text-center"> Testimonial CRUD </h3>
    </div>
    
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-end">
        <a href="javascript:void(0)" id="create-testimonial-btn" class="btn btn-primary"> Create Testimonial </a>
    </div>
</div>

<div class="card my-3">
    <table class="table " id="testimonialTable">
        <thead>
            <tr>
                <th width="5%">Id</th>
                <th width="10%">Name</th>
                <th width="10%">Email</th>
                <th width="5%">Rating</th>
                <th width="5%">Status</th>
                <th width="30%">Message</th>
                <th width="25%">Action</th>
            <tr>
        </thead>

        <tbody>
            @forelse ($testimonials as $testimonial)
                <tr id="testimonial_{{$testimonial->id}}">
                    <td>{{ $testimonial->id }}</td>
                    <td>{{ $testimonial->name }}</td>
                    <td>{{ $testimonial->email }}</td>
                    <td>{{ $testimonial->rating }}</td>
                    <td>{{ $testimonial->status }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 150, $end='...') }}</td>
                    <td>
                        <a href="javascript:void(0)" data-id="{{$testimonial->id}}" title="View" class="btn btn-sm btn-info btn-view"> View </a>
                        <a href="javascript:void(0)" data-id="{{$testimonial->id}}" title="Edit" class="btn btn-sm btn-success btn-edit"> Edit </a>
                        <a href="javascript:void(0)" data-id="{{$testimonial->id}}" title="Delete" class="btn btn-sm btn-danger btn-delete"> Delete </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <p class="text-danger text-center"> No Testimonial found! </p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
 <div class="d-flex testi-paginate justify-content-center">
            {!! $testimonials->links() !!}
        </div>

<!-- modal -->
<div class="modal fade" id="testimonialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
        <form method="post" id="testimonialForm">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"> Testimonial Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" name="rating" class="form-control" id="rating" placeholder="Rating" min="1" max="5">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="number" name="status" class="form-control" id="status" placeholder="Status" min="0" max="1">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" name="message" placeholder="message" id="message" rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
