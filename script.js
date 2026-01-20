
// Database Connection Configuration

// Navigation Functionality

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the page
    initializeNavigation();
    fetchStatistics();
    addSmoothScrolling();
});

// Navigation Card Handlers

function initializeNavigation() {
    const viewWorkoutsCard = document.getElementById('viewWorkouts');
    const addWorkoutCard = document.getElementById('addWorkout');
    const viewExercisesCard = document.getElementById('viewExercises');

    if (viewWorkoutsCard) {
        viewWorkoutsCard. addEventListener('click', function() {
            navigateTo('gym-exercise-log/views/workouts.php');
        });
        viewWorkoutsCard.setAttribute('tabindex', '0');
        addKeyboardNavigation(viewWorkoutsCard, 'gym-exercise-log/views/workouts.php');
    }

    if (addWorkoutCard) {
        addWorkoutCard. addEventListener('click', function() {
            navigateTo('gym-exercise-log/views/add_workout.php');
        });
        addWorkoutCard.setAttribute('tabindex', '0');
        addKeyboardNavigation(addWorkoutCard, 'gym-exercise-log/views/add_workout. php');
    }

    if (viewExercisesCard) {
        viewExercisesCard.addEventListener('click', function() {
            // Go to workouts page since exercises need a workout_id
            navigateTo('gym-exercise-log/views/workouts.php');
        });
        viewExercisesCard.setAttribute('tabindex', '0');
        addKeyboardNavigation(viewExercisesCard, 'gym-exercise-log/views/workouts.php');
    }
}

function navigateTo(url) {
    // Add elegant fade transition
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.3s ease';
    
    setTimeout(function() {
        window.location.href = url;
    }, 300);
}

function addKeyboardNavigation(element, url) {
    element.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            navigateTo(url);
        }
    });
}

// Fetch Statistics from Database

async function fetchStatistics() {
    try {
        // Fetch total workouts
        const totalWorkouts = await fetchTotalWorkouts();
        updateStatDisplay('totalWorkouts', totalWorkouts);

        // Fetch total exercises
        const totalExercises = await fetchTotalExercises();
        updateStatDisplay('totalExercises', totalExercises);

        // Fetch recent activity (days active)
        const daysActive = await fetchDaysActive();
        updateStatDisplay('recentActivity', daysActive);

    } catch (error) {
        console.error('Error fetching statistics:', error);
        // Display placeholder values on error
        updateStatDisplay('totalWorkouts', '0');
        updateStatDisplay('totalExercises', '0');
        updateStatDisplay('recentActivity', '0');
    }
}

// API Functions - Database Queries

async function fetchTotalWorkouts() {
    try {
        const response = await fetch('gym-exercise-log/api/get_stats. php? type=workouts');
        if (!response.ok) throw new Error('Failed to fetch workouts');
        const data = await response.json();
        return data.total || 0;
    } catch (error) {
        console.error('Error fetching total workouts:', error);
        return 0;
    }
}

async function fetchTotalExercises() {
    try {
        const response = await fetch('gym-exercise-log/api/get_stats.php?type=exercises');
        if (!response.ok) throw new Error('Failed to fetch exercises');
        const data = await response.json();
        return data.total || 0;
    } catch (error) {
        console.error('Error fetching total exercises:', error);
        return 0;
    }
}

async function fetchDaysActive() {
    try {
        const response = await fetch('gym-exercise-log/api/get_stats. php?type=days_active');
        if (!response.ok) throw new Error('Failed to fetch days active');
        const data = await response.json();
        return data.days || 0;
    } catch (error) {
        console.error('Error fetching days active:', error);
        return 0;
    }
}


function updateStatDisplay(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        // Animate the number change
        animateValue(element, 0, value, 1000);
    }
}

function animateValue(element, start, end, duration) {
    const range = end - start;
    const increment = range / (duration / 16); // 60 FPS
    let current = start;
    
    const timer = setInterval(function() {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}


// Smooth Scrolling Enhancement


function addSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Loading State Management

function showLoading() {
    document.body.style.cursor = 'wait';
}

function hideLoading() {
    document.body.style.cursor = 'default';
}

// Error Handling

function handleError(error, context) {
    console.error(`Error in ${context}:`, error);
}

// Responsive Utilities

// Detect mobile devices
function isMobileDevice() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Add mobile-specific class if needed
if (isMobileDevice()) {
    document.body. classList.add('mobile-device');
}