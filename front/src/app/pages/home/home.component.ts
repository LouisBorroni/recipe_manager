import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../servcices/auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  imports: [CommonModule],
})
export class HomeComponent {
  constructor(private authService: AuthService) {
  }

  logout() {
    this.authService.logout()
  }
}
