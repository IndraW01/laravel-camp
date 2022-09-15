<x-app-layout>
    <section class="dashboard" style="margin-top: 100px">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        User Camp Checkouts
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            Camp Checkouts
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Camp</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Register Date</th>
                                        <th scope="col">Paid Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($checkouts as $checkout)
                                    <tr>
                                        <th scope="row">{{ $checkout->user->name }}</th>
                                        <td>{{ $checkout->camp->title }}</td>
                                        <td>{{ $checkout->camp->price }}</td>
                                        <td>{{ $checkout->created_at }}</td>
                                        <td>
                                            {!! $checkout->is_paid ?
                                            '<span class="badge bg-success">Paid</span>' :
                                            '<span class="badge bg-warning">Waiting</span>' !!}
                                        </td>
                                        <td>
                                            @if (!$checkout->is_paid)
                                            <form action="{{ route('checkout.paid', $checkout) }}" method="POST"
                                                class="formPaid">
                                                @csrf
                                                <button type="submit" name="paid" class="btn btn-primary"
                                                    data-name="{{ $checkout->user->name }}"
                                                    data-camp="{{ $checkout->camp->title }}">Set to
                                                    Paid</button>
                                            </form>
                                            @else
                                            <button type="button" class="btn btn-secondary"
                                                style="width: 157px">Success</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <h3 class="text-center">Checkout Not Found</h3>
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
        const formPaid = document.querySelectorAll('.formPaid');
        formPaid.forEach(form => {
            form.addEventListener('submit', function(event) {
                const buttonPaidName = this.lastElementChild.dataset.name;
                const buttonPaidCamp = this.lastElementChild.dataset.camp;
                event.preventDefault();

                Swal.fire({
                    title: `Set to Paid User ${buttonPaidName} and Camp ${buttonPaidCamp}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Paid!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                })
            });
        });


    </script>
    @endpush
</x-app-layout>
