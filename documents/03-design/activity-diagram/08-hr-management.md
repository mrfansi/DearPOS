```mermaid
graph TD
    Start([Start]) --> NavigateToHRManagement[Navigate to HR Management Module]

    NavigateToHRManagement --> ManageEmployees[Manage Employees]
    ManageEmployees --> AddEmployee[Add New Employee]
    AddEmployee --> EnterEmployeeDetails[Enter Employee Details: Name, Position, Department]
    EnterEmployeeDetails --> AssignBenefits[Assign Benefits]
    AssignBenefits --> SaveEmployee[Save Employee Information]
    SaveEmployee --> End([End])

    ManageEmployees --> EditEmployee[Edit Existing Employee]
    EditEmployee --> UpdateEmployeeDetails[Update Details: Position, Department, Benefits]
    UpdateEmployeeDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageEmployees --> DeleteEmployee[Delete Employee]
    DeleteEmployee --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveEmployee[Remove Employee from System]
    RemoveEmployee --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToHRManagement --> ManageShifts[Manage Shifts]
    ManageShifts --> CreateShift[Create New Shift Schedule]
    CreateShift --> EnterShiftDetails[Enter Shift Details: Start Time, End Time, Employees]
    EnterShiftDetails --> SaveShift[Save Shift Schedule]
    SaveShift --> End

    ManageShifts --> EditShift[Edit Existing Shift]
    EditShift --> UpdateShiftDetails[Update Shift Time or Employees]
    UpdateShiftDetails --> SaveChanges[Save Changes]
    SaveChanges --> End

    ManageShifts --> DeleteShift[Delete Shift]
    DeleteShift --> ConfirmDeletion[Confirm Deletion]
    ConfirmDeletion -->|Yes| RemoveShift[Remove Shift Schedule]
    RemoveShift --> End
    ConfirmDeletion -->|No| CancelOperation[Cancel Operation]
    CancelOperation --> End

    NavigateToHRManagement --> ManagePerformanceReviews[Manage Performance Reviews]
    ManagePerformanceReviews --> ConductReview[Conduct Performance Review]
    ConductReview --> EnterReviewDetails[Enter Review Details: Ratings, Comments, Goals]
    EnterReviewDetails --> SaveReview[Save Performance Review]
    SaveReview --> End

    NavigateToHRManagement --> ManageLeaveRequests[Manage Leave Requests]
    ManageLeaveRequests --> ReviewLeaveRequest[Review Leave Request]
    ReviewLeaveRequest --> ApproveLeave[Approve Leave Request]
    ApproveLeave --> SaveApproval[Save Approval]
    SaveApproval --> End
    ReviewLeaveRequest --> RejectLeave[Reject Leave Request]
    RejectLeave --> SaveRejection[Save Rejection]
    SaveRejection --> End
```

### **Penjelasan Diagram:**
1. **Employee Management Workflow:**
   - Menambahkan, mengedit, atau menghapus data karyawan.
   - Mengelola informasi seperti posisi, departemen, dan manfaat.

2. **Shift Management Workflow:**
   - Membuat jadwal shift baru, memperbarui jadwal shift, atau menghapus jadwal yang ada.

3. **Performance Review Workflow:**
   - Melakukan evaluasi kinerja karyawan dengan memberikan penilaian, komentar, dan menetapkan tujuan.

4. **Leave Request Workflow:**
   - Meninjau permohonan cuti karyawan, memberikan persetujuan, atau menolak permohonan.