@if(session()->has('success'))
<script>
$(document).Toasts('create', {
    title: 'Success',
    body: '{{ session('success') }}',
    autohide: true,
    delay: 4000,
    class: 'bg-success flash-success',
    position: 'bottomRight'
});
</script>
@endif

@if(session()->has('status'))
<?php
    $message = session('status');
    if (session('status') == 'profile-information-updated') $message = 'Profile updated successfully.';
    if (session('status') == 'password-updated') $message = 'Password updated successfully.';
?>
<script>
$(document).Toasts('create', {
    title: 'Success',
    body: '{{ $message }}',
    autohide: true,
    delay: 4000,
    class: 'bg-success flash-success',
    position: 'bottomRight'
});
</script>
@endif