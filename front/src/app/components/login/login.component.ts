import { Component } from '@angular/core';
import { AuthService } from '../../servcices/auth.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  standalone: true,
  imports: [CommonModule, FormsModule]
})
export class LoginComponent {
  credentials: { email: string; password: string } = { email: '', password: '' };

  constructor(private authService: AuthService) {}

  async onSubmit() {
    if (!this.credentials.email || !this.credentials.password) {
      console.error('Both username and password are required!');
      return;
    }

    try {
      const response = await this.authService.login(this.credentials);
      console.log('User logged in successfully!', response);
      localStorage.setItem('token', response.token);
    } catch (error) {
      console.error('Error logging in:', error);
    }
  }
}
