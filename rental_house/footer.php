<style>
  

.text-small {
  font-size: 0.9rem;
}

a {
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}

a:hover, a:focus {
  text-decoration: none;
}

.form-control {
  background: #212529;
  border-color: #545454;
}

.form-control:focus {
  background: #212529;
}

footer {
  background: #212529;
  margin-top: auto;
}


/* ==========================================
    CUSTOM UTILS CLASSES
  ========================================== */

  .yellow-button {
            background-color: #FFD700; /* Yellow color */
            color: #fff; /* Text color */
            padding: 10px 20px; /* Adjust padding as needed */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor to pointer on hover */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        /* Hover effect */
        .yellow-button:hover {
            background-color: #FFC107; /* Darker shade of yellow on hover */
        }

 

</style>

<style>
    /* Custom CSS to override Visme form container background color */
    #vismeFormContainer {
        background-color: transparent !important;
    }
</style>



    <!-- FOOTER -->
    <footer class="w-100 py-4 flex-shrink-0">
        <div class="container py-4">
            <div class="row gy-4 gx-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="h1 text-white">FB.</h5>
                    <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                    <p class="small text-muted mb-0">&copy; Copyrights. All rights reserved.<?php echo date("Y"); ?> <a class="text-primary" href="#">Bootstrapious.com</a></p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Quick links</h5>
                    <ul class="list-unstyled text-muted">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Get started</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Quick links</h5>
                    <ul class="list-unstyled text-muted">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Get started</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>


<div class="col-lg-4 col-md-6">
    <h5 class="text-white mb-3">GET IN TOUCH</h5>
    <p class="small text-muted">Click the button to reach us...</p>
    <!-- Button to Trigger Form Display -->
    <button id="showFormBtn" class="btn btn-primary">Click Here</button>
    <!-- Form Container (Initially Hidden) -->
    <div id="formContainer" style="display: none;">
        <form action="#">
            <div class="visme_d" data-title="Untitled Project" data-url="jwokvvmq-untitled-project?fullPage=true" data-domain="forms" data-full-page="true" data-min-height="100vh" data-form-id="44857"></div>
    <script src="https://static-bundles.visme.co/forms/vismeforms-embed.js"></script>
        </form>
    </div>
</div>





            </div>
        </div>
    </footer>
</div>
</body>

<script>
    // Get references to the button and form container
    var showFormBtn = document.getElementById('showFormBtn');
    var formContainer = document.getElementById('formContainer');

    // Add event listener to the button
    showFormBtn.addEventListener('click', function() {
        // Toggle the display of the form container
        if (formContainer.style.display === 'none') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    });
</script>


