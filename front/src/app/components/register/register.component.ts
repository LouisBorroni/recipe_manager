import { Component } from '@angular/core';
import { AuthService } from '../../servcices/auth.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
  standalone: true,
  imports: [CommonModule, FormsModule]
})
export class RegisterComponent {
  user: { username: string; email: string; password: string; confirmPassword: string } = {
    username: '',
    email: '',
    password: '',
    confirmPassword: ''
  };

  constructor(private authService: AuthService, private router: Router) {}

  async onSubmit() {
    if (this.user.password !== this.user.confirmPassword) {
      console.error('Les mots de passe ne correspondent pas');
      return; // Empêche l'envoi du formulaire si les mots de passe ne correspondent pas
    }

    try {
      const response = await this.authService.register(this.user);
      console.log('User registered successfully!', response);
    } catch (error) {
      console.error('Error registering user:', error);
    }
  }
}
