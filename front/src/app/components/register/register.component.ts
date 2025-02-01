import { Component } from '@angular/core';
import { AuthService } from '../../servcices/auth.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
  standalone: true,
  imports: [CommonModule, FormsModule]
})
export class RegisterComponent {
  user: { email: string; pseudo: string; password: string; confirmPassword: string } = {
    pseudo: '',
    email: '',
    password: '',
    confirmPassword: ''
  };

  constructor(private authService: AuthService, private router: Router) {}

  async onSubmit() {
    if (this.user.password !== this.user.confirmPassword) {
      return;
    }

    try {
      const response = await this.authService.register(this.user);
      console.log('User registered successfully!');
    } catch (error) {
      console.error('Error registering user:', error);
    }
  }
}
