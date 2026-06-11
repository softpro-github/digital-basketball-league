@extends('layouts.app')
@section('title','Users')
@section('page-title','Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Users</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-warning"><i class="bi bi-person-plus me-1"></i>New User</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $users->firstItem() + $loop->index }}</td>
                <td class="fw-semibold">{{ $u->name }}</td>
                <td class="text-muted small">{{ $u->email }}</td>
                <td>
                    <span class="badge bg-{{ $u->role === 'admin' ? 'danger' : ($u->role === 'coach' ? 'primary' : 'success') }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td class="small text-muted">{{ $u->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    @if($u->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="d-inline" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
