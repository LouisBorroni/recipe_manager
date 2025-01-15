import { Component } from '@angular/core';
import { AuthService } from '../../servcices/auth.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
  standalone: true,
  imports: [CommonModule, FormsModule]
})
export class RegisterComponent {
  user: { username: string; email: string; password: string } = { username: '', email: '', password: '' };

  constructor(private authService: AuthService) {}

  async onSubmit() {
    try {
      const response = await this.authService.register(this.user);
      console.log('User registered successfully!', response);
    } catch (error) {
      console.error('Error registering user:', error);
    }
  }
}
