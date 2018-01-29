# features/login.feature
Feature: Login operations
    In order to access the interface
    As a visitor
    I need to be able to log in to the website

    Scenario: Go to login page
        Given I am on "/login"
        Then I should see "Entrar" in the "#id-enter" element
    
    @complete      
    @javascript    
    Scenario: Logout nsed the user to login page
        Given I reset the session
         When I am on "/logout"
          And I wait 3 seconds
         Then I should be on "/login"
          And I should see "Entrar"
    
    @complete
    @javascript   
    Scenario: Log in with username and password
        Given I reset the session
         When I am on "/login"
         And I fill in the following:
            | id-user | superadmin |
            | id-pass | toor01 |
          And I press "id-enter" button
          And I wait for the error box to appear
         Then I should be on "/login"
          And I should see "El usuario o contraseña no existen"
    
    @complete
    @javascript    
    Scenario: Log in with username and password
        Given I reset the session
         When a "large" window size is being used
          And I am on "/login"
          And I fill in the following:
            | id-user | superadmin |
            | id-pass | toor00 |
          And I press "id-enter" button
          And I wait go "/" for 6 seconds
         Then I should be on "/"
          And I should see "Turnos"
          And I should see "Salir"
          And I should see "Parámetros del sistema"
    
    @complete      
    @javascript    
    Scenario: Go to Home without login user
        Given I reset the session
         When I am on "/"
         Then I should be on "/login"
          And I should see "Entrar"
    
    @complete
    @javascript    
    Scenario: Go to list User page without login user
        Given I reset the session
         When I am on "/admin/user"
         Then I should be on "/login"
          And I should see "Entrar"
    
    @complete      
    @javascript    
    Scenario: Go to list user page after login user
    	Given I reset the session
         When I am authenticated as "superadmin"
         And I am on "/admin/user/"
         And I wait go "/admin/user/" for 3 seconds
         Then I should be on "/admin/user/"
          And I should see "Usuarios"
          And I should see "Crear usuario"
          
    @complete      
    @javascript    
    Scenario: Go to list user page after login user
    	Given I reset the session
         When I am authenticated as "superadmin"
          And I am on "/admin/user/"
          And I wait 3 seconds
         Then I should be on "/admin/user/"
          And I should see "Usuarios"
          And I should see "Crear usuario"
        