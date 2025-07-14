@extends('backend.master')
@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Post
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Thumbnail</th>
                  <th>Description</th>
                  <th>Author</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </tr>
              </thead>
                
                
                <tbody class="table-border-bottom-0">
                  @foreach($news as $new) 
                    <tr>
                      <td > <img src="/uploads/{{ $new->thumbnail }}" class="w-px-50" alt="thumbnail"> </td>
                      <td>
                          {{ substr($new->description, 0, 30).'...' }}
                      </td>
                      <td> <span class="badge bg-label-primary me-1"> {{ $new->username }} </span> </td>
                      <td> <span class="badge bg-label-danger me-1"> {{ $new->created_at }} </span> </td>
                      <td> <span class="badge bg-label-info me-1"> {{ $new->updated_at }} </span> </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="/admin/update-news/{{ $new->id }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item remove-post-key" data-bs-toggle="modal" data-value="{{ $new->id }}" data-bs-target="#basicModal" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>

        <div class="mt-3">
          <form action="/admin/remove-news-submit" method="post">
            @csrf
          <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="remove" id="remove-val" name="remove_id">
                  <button type="submit" class="btn btn-danger">Confirm</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        
      <hr class="my-5" />
    </div>
    <!-- / Content -->
  </div>
</div>

@endsection
