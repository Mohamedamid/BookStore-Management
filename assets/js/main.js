// JavaScript for dynamic actions (optional)
// Here we can add interactivity like fetching data, handling button clicks, etc.

// Example function to show an alert when a button is clicked.
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', () => {
        alert('Button clicked!');
    });
});
