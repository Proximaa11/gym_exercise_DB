// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
});

// Navigation setup
function initializeNavigation() {
    const viewWorkoutsCard = document.getElementById('viewWorkouts');
    const addWorkoutCard = document.getElementById('addWorkout');

    if (viewWorkoutsCard) {
        viewWorkoutsCard.addEventListener('click', function() {
            window.location.href = 'views/workouts.php';
        });
        
        // Keyboard navigation
        viewWorkoutsCard.setAttribute('tabindex', '0');
        viewWorkoutsCard.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.location.href = 'views/workouts.php';
            }
        });
    }

    if (addWorkoutCard) {
        addWorkoutCard.addEventListener('click', function() {
            window.location.href = 'views/add_workout.php';
        });
        
        // Keyboard navigation
        addWorkoutCard.setAttribute('tabindex', '0');
        addWorkoutCard.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.location.href = 'views/add_workout.php';
            }
        });
    }
}
