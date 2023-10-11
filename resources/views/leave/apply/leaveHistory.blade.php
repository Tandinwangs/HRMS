@extends('layout')

@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

              
    @if(session('error'))
            <div id="error-message" class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">
        Apply Leave
    </button>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Apply for Leave</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('applyleave.store') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ auth()->user()->id }}" required readonly>
                            </div>  

                            <div class="form-group">
                                <label for="leave_typr">Leave Type</label>
                                <select id="leave_type_select" name="leave_id" class="form-control">
                                    <!-- Populate this dropdown with available leave types -->
                                    <option selected disabled>Select Type</option>
                                    @foreach($leave_types as $leave)
                                    <option value="{{ $leave->id }}">{{ $leave->name }}</option>
                                    @endforeach
                                    <!-- Add more options as needed -->
                                    @error('leave_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="leave_balance">Leave Balance</label>
                                <input type="text" id="leave_balance" name="leave_balance" class="form-control" readonly required>
                            </div>

                            <div class="form-group mt-3">
                                <select id="day_type_start" name="day_type_start" class="form-control" required>
                                    <option value="full_day">Full Day</option>
                                    <option value="first_half">First Half</option>
                                    <option value="second_half">Second Half</option>
                                    <option value="shift">Shift</option>
                                </select>
                                <label for="start_date">From Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                                @error('start_date')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <select id="day_type_end" name="day_type_end" class="form-control" required>
                                    <option value="full_day">Full Day</option>
                                    <option value="first_half">First Half</option>
                                    <option value="second_half">Second Half</option>
                                    <option value="shift">Shift</option>
                                </select>
                                <label for="end_date">To Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required>
                                @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="number_of_days">No. of Days</label>
                                <input type="number" id="number_of_days" name="number_of_days" class="form-control" required readonly>
                                @error('number_of_days')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
                                @error('remark')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="file_path">Attach File</label>
                                <input type="file" id="file_path" name="file_path" class="form-control-file">
                                @error('file_path')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                </form>
            </div>
        </div>
    </div>


        <table class="table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>No.of Days</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($leaveHistory->count() > 0)
                @foreach($leaveHistory as $history)
                    <tr>
                        <td>{{ $history->employee->name }}</td>
                        <td>{{ $history->leavetype->name }}</td>
                        <td>{{ $history->start_date }}</td>
                        <td>{{ $history->end_date }}</td>
                        <td>{{ $history->number_of_days }}</td>
                         <td>{{$history->status}}</td>
                        <td>
                            <a href="" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('leavePolicy.view', ['leave_id' => $history->leave_id])}}" class="btn btn-primary btn-sm">View</a> 
                        </td>
                    </tr>
                @endforeach
                @else
                <h1>No datas</h1>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

    <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>

<script>
    // Get references to the leave type and leave balance elements
    var leaveTypeSelect = document.getElementById('leave_type_select');
    var leaveBalanceInput = document.getElementById('leave_balance');

    // Add an event listener to the leave type dropdown
    leaveTypeSelect.addEventListener('change', function() {
        var selectedLeaveTypeId = this.value;

        // Clear the existing leave balance
        leaveBalanceInput.value = '';

        // Make an AJAX request to fetch the leave balance
        fetch('/fetch-leave-balance/' + selectedLeaveTypeId)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                var leaveBalance = data.balance;

                // Update the leave balance input with the fetched value
                leaveBalanceInput.value = leaveBalance;
            })
            .catch(function(error) {
                console.error('Error fetching leave balance:', error);
            });
    });

</script>

<!-- <script>
    $(document).ready(function () {
        // Add event listeners for day type, date fields, and day type start
        $('#day_type_start, #day_type_end, #start_date, #end_date').on('change', function () {
            updateNumberOfDays();
        });

        // Add a separate event listener for day type start
        $('#day_type_start').on('change', function () {
            updateNumberOfDaysForStartDate();
        });

        // Add an event listener to the leave type dropdown
        $('#leave_type_select').on('change', function () {
            // Get the selected leave type ID
            const selectedLeaveTypeId = $(this).val();

            // Check if a leave type is selected
            if (selectedLeaveTypeId) {
                // Fetch the include_weekends setting for the selected leave type
                fetchIncludeWeekends(selectedLeaveTypeId)
                    .then(function (includeWeekends) {
                        // Handle the include_weekends data here
                        console.log('include_weekends:', includeWeekends);

                        // Now, you can update the UI or perform other actions based on includeWeekends
                        // For now, we'll just log it to the console.

                        // Update the number of days calculation based on include_weekends
                        updateNumberOfDays(includeWeekends);
                    });
            }
        });

        // Function to fetch the include_weekends setting for the selected leave type
        function fetchIncludeWeekends(selectedLeaveTypeId) {
            return fetch('/fetch-include-weekends/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.include_weekends;
                })
                .catch(function (error) {
                    console.error('Err  or fetching include_weekends:', error);
                    return false; // Default to false if there's an error
                });
    }

        function updateNumberOfDays(includeWeekends) {
            const dayTypeStart = $('#day_type_start').val();
            const dayTypeEnd = $('#day_type_end').val();
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());
            let numberOfDays = 0.0;

            while (startDate <= endDate) {
                const isSunday = startDate.getDay() === 0;
                const isSaturday = startDate.getDay() === 6;

                if (includeWeekends || (!isSunday && !isSaturday)) {
                    if (startDate.getTime() === startDate.getTime() && dayTypeStart !== 'full_day') {
                        numberOfDays += 0.5;
                    } else if (startDate.getTime() === endDate.getTime() && dayTypeEnd !== 'full_day') {
                        numberOfDays += 0.5;
                    } else {
                        numberOfDays += 1;
                    }
                }

                startDate.setDate(startDate.getDate() + 1);
            }

            $('#number_of_days').val(numberOfDays);
        }

        function updateNumberOfDaysForStartDate() {
            const dayTypeStart = $('#day_type_start').val();
            let numberOfDays = 0.0;

            if (dayTypeStart === 'full_day') {
                numberOfDays = 1;
            } else if (dayTypeStart === 'first_half' || dayTypeStart === 'second_half') {
                numberOfDays = 0.5;
            } else if (dayTypeStart === 'shift') {
                // Implement logic for 'shift' if needed
            }

            $('#number_of_days').val(numberOfDays);
        }


        // Initial calculation when the page loads
        updateNumberOfDays();
    });
</script>  -->

<script>
    $(document).ready(function () {
        // Function to fetch the include_weekends setting for the selected leave type
        function fetchIncludeWeekends(selectedLeaveTypeId) {
            return fetch('/fetch-include-weekends/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.include_weekends;
                })
                .catch(function (error) {
                    console.error('Error fetching include_weekends:', error);
                    return false; // Default to false if there's an error
                });
        }

        // Function to fetch the include_public_holidays setting for the selected leave type
        function fetchIncludePublicHolidays(selectedLeaveTypeId) {
            return fetch('/fetch-include-public-holidays/' + selectedLeaveTypeId)
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.include_public_holidays;
                })
                .catch(function (error) {
                    console.error('Error fetching include_public_holidays:', error);
                    return false; // Default to false if there's an error
                });
        }

        // Function to fetch the list of holiday dates
        function fetchHolidayDates() {
            return fetch('/fetch-holiday-dates')
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    return data.holiday_dates;
                })
                .catch(function (error) {
                    console.error('Error fetching holiday dates:', error);
                    return [];
                });
        }

       // Function to calculate the number of days
        function calculateNumberOfDays(startDate, endDate, dayTypeStart, dayTypeEnd, includeWeekends, includePublicHolidays, holidayDates) {
            let numberOfDays = 0.0;
            const millisecondsPerDay = 24 * 60 * 60 * 1000;

            while (startDate <= endDate) {
                const isSunday = startDate.getDay() === 0;
                const isSaturday = startDate.getDay() === 6;
                const isHoliday = holidayDates.includes(startDate.toISOString().split('T')[0]);

                if (includeWeekends || (!isSunday && !isSaturday)) {
                    if (includePublicHolidays || !isHoliday) {
                        if (startDate.toDateString() === endDate.toDateString()) {
                            if (dayTypeStart === 'first_half' || dayTypeStart === 'second_half') {
                                numberOfDays += 0.5;
                            } else {
                                numberOfDays += 1;
                            }
                        } else {
                            numberOfDays += 1;
                        }
                    }
                } else if (!includeWeekends && isSaturday) {
                    numberOfDays += 0.5; // Add 0.5 for Saturdays when weekends are not included
                }

                startDate.setTime(startDate.getTime() + millisecondsPerDay);
            }

            if ((dayTypeEnd === 'first_half' || dayTypeEnd === 'second_half') && numberOfDays > 0) {
                numberOfDays -= 0.5;
            }

            return numberOfDays;
        }


        // Update the number of days and set it in the UI
        function updateNumberOfDays(includeWeekends, includePublicHolidays) {
            const dayTypeStart = $('#day_type_start').val();
            const dayTypeEnd = $('#day_type_end').val();
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());

            // Fetch the list of holiday dates
            fetchHolidayDates()
                .then(function (holidayDates) {
                    console.log('dates', holidayDates);
                    const numberOfDays = calculateNumberOfDays(
                        startDate,
                        endDate,
                        dayTypeStart,
                        dayTypeEnd,
                        includeWeekends,
                        includePublicHolidays,
                        holidayDates
                    );
                    $('#number_of_days').val(numberOfDays);
                });
        }

        // Add event listeners for day type, date fields, and leave type
        $('#day_type_start, #day_type_end, #start_date, #end_date, #leave_type_select').on('change', function () {
            const selectedLeaveTypeId = $('#leave_type_select').val();

            // Fetch the include_weekends setting for the selected leave type
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    // Fetch the include_public_holidays setting for the selected leave type
                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            // Calculate the number of days and update the UI
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                        });
                });
        });

        // Initial calculation when the page loads
        updateNumberOfDays(false, false); // Default to exclude weekends and public holidays

        // Additional event listeners for start_date and end_date
        $('#start_date, #end_date').on('change', function () {
            // Calculate the number of days when start_date or end_date changes
            const selectedLeaveTypeId = $('#leave_type_select').val();
            fetchIncludeWeekends(selectedLeaveTypeId)
                .then(function (includeWeekends) {
                    fetchIncludePublicHolidays(selectedLeaveTypeId)
                        .then(function (includePublicHolidays) {
                            updateNumberOfDays(includeWeekends, includePublicHolidays);
                        });
                });
        });
    });

</script>




<!-- <script>
    // Function to calculate the number of days considering weekends
    function calculateNumberOfDays() {
        const startDate = new Date(document.getElementById("start_date").value);
        const endDate = new Date(document.getElementById("end_date").value);
        const dayTypeStart = document.getElementById("day_type_start").value;
        const dayTypeEnd = document.getElementById("day_type_end").value;

        // Calculate the number of days between start and end dates
        const millisecondsPerDay = 24 * 60 * 60 * 1000;
        const days = (endDate - startDate) / millisecondsPerDay + 1;

        // Consider weekends (Saturdays and Sundays) if necessary
        let numberOfDays = days;
        if (dayTypeStart === "first_half") {
            numberOfDays -= 0.5; // Subtract half a day from the start
        }
        if (dayTypeEnd === "second_half") {
            numberOfDays -= 0.5; // Subtract half a day from the end
        }

        // Update the input field with the calculated value
        document.getElementById("number_of_days").value = numberOfDays;
    }

    // Add an event listener to trigger the calculation when date or day_type changes
    document.getElementById("start_date").addEventListener("change", calculateNumberOfDays);
    document.getElementById("end_date").addEventListener("change", calculateNumberOfDays);
    document.getElementById("day_type_start").addEventListener("change", calculateNumberOfDays);
    document.getElementById("day_type_end").addEventListener("change", calculateNumberOfDays);

    // Initial calculation
    calculateNumberOfDays();
</script> -->



@endsection