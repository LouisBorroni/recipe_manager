import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../servcices/auth.service';
import { SidebarComponent } from '../../components/sidebar/sidebar.component';
import { HomeContentComponent } from '../../components/home-content/home-content.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  imports: [CommonModule, SidebarComponent, HomeContentComponent],
})
export class HomeComponent {
  constructor(private authService: AuthService) {
  }

  logout() {
    this.authService.logout()
  }
}
