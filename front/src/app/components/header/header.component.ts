import { Component } from '@angular/core';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs';
import { selectUser } from '../../stores/user/user.selector'; // Crée l'action logout si elle n'existe pas
import { clearUser } from '../../stores/user/user.actions';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../servcices/auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss'],
  imports: [CommonModule]
})
export class HeaderComponent {
  user$: Observable<any>; // L'observable pour le user

  constructor(private store: Store, private authService: AuthService) {
    // Récupère l'utilisateur du store
    this.user$ = this.store.select(selectUser);
  }

  // Fonction de déconnexion
  logout() {
    this.authService.logout(); // Action pour déconnecter l'utilisateur
  }
}
