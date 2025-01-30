import { Component } from '@angular/core';

@Component({
  selector: 'app-sidebar',
  imports: [],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.scss'
})
export class SidebarComponent {
  selectedButton: string = 'recipes'; 
  
  selectButton(button: string): void {
    this.selectedButton = button;
  }
}
