import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../servcices/auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit{
  constructor(private authService: AuthService) {}

  ngOnInit(): void {
    console.log("salut");
  }
  logout() {
    this.authService.logout();
  }
}
