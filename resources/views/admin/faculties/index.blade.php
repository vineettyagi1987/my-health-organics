@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Our Staff Members</h3>

        <a href="{{ route('admin.faculties.create') }}" class="btn btn-primary">
            Add Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <table class="table table-bordered">

        <thead class="">
            <tr>
               <th>S.No.</th>
                <th>Image</th>
                <th>Name</th>
                <!-- <th>Email</th> -->
                <th>Designation</th>
                <th>Qualifications</th>
                <th>Bio</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($faculties as $faculty)

            <tr>

                <td>{{ $faculties->firstItem() + $loop->index }}</td>

                <td>
                    @if($faculty->image)
                        <img src="{{ asset('storage/'.$faculty->image) }}" width="70" class="rounded">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>

                <td>{{ $faculty->name }}</td>

                <!-- <td>{{ $faculty->email }}</td> -->

                <td>{{ $faculty->designation }}</td>

                <td>{{ $faculty->qualifications }}</td>

                <td style="max-width:200px;">
                    {{ Str::limit($faculty->bio, 100) }}
                </td>

                <td>

                    <a href="{{ route('admin.faculties.edit',$faculty->id) }}"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('admin.faculties.destroy',$faculty->id) }}"
                          method="POST"
                          style="display:inline-block">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete Team Member?')">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" class="text-center text-muted">
                    No Team Members Found
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
{{ $faculties->links() }}
</div>

@endsection