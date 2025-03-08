            </div><!-- .content-wrapper -->
        </div><!-- .main-content -->
    </div><!-- .admin-wrapper -->
    
    <script>
        // User dropdown toggle
        document.getElementById('userDropdown').addEventListener('click', function() {
            document.getElementById('userDropdownMenu').classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdownMenu');
            const toggle = document.getElementById('userDropdown');
            
            if (!toggle.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html> 