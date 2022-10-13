<x-app-layout>
    <section class="dashboard" style="margin-top: 100px">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        Management Discount
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            Discount
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{ route('admin.discount.create') }}" class="btn btn-primary btn-sm">Add
                                        Discount</a>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Percentage</th>
                                        <th scope="col" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($discounts as $discount)
                                    <tr>
                                        <th scope="row">{{ $discount->name }}</th>
                                        <td>
                                            <span class="badge bg-primary">{{ $discount->code }}</span>
                                        </td>
                                        <td>{{ $discount->description ?? '-' }}</td>
                                        <td>{{ $discount->percentage }}%</td>
                                        <td>
                                            <a href="{{ route('admin.discount.edit', ['discount' => $discount->id]) }}"
                                                class="btn btn-warning">Update</a>
                                            <form id="formDeleteDiscount"
                                                action="{{ route('admin.discount.destroy', ['discount' => $discount->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <h3 class="text-center">Discount Not Found</h3>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('costum-js')
    <script>
        const formDeleteDiscount = document.getElementById('formDeleteDiscount');
        formDeleteDiscount.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
            title: 'Are you Delet?',
            text: "Anda Yakin ingin menghapus discount!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                formDeleteDiscount.submit();
            }
            })
        });

    </script>
    @endpush
</x-app-layout>
