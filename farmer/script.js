document.addEventListener("DOMContentLoaded", function() {
    let jobs = JSON.parse(localStorage.getItem("jobs")) || [];

    const jobsContainer = document.getElementById("jobs-container");

    function displayJobs(filter = "") {
        jobsContainer.innerHTML = "";
        jobs.forEach(job => {
            if (job.title.toLowerCase().includes(filter.toLowerCase())) {
                let jobElement = document.createElement("div");
                jobElement.classList.add("job");
                jobElement.innerHTML = `
                    <div class="job-header">
                        <img src="${job.profileImage}" alt="Profile" class="profile-pic">
                        <span class="username">${job.username}</span>
                    </div>
                    <h3>${job.title}</h3>
                    <p>Location: ${job.location}</p>
                    <p>Salary: ${job.salary}</p>
                    <a href="apply.html?job=${job.title}">Apply Now</a>
                `;
                jobsContainer.appendChild(jobElement);
            }
        });
    }

    document.getElementById("search").addEventListener("input", function() {
        displayJobs(this.value);
    });

    displayJobs();
});
