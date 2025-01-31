import { Component, EventEmitter, Output } from '@angular/core';

@Component({
  selector: 'app-sidebar',
  imports: [],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.scss'
})
export class SidebarComponent {
  @Output() sectionChange = new EventEmitter<string>();
  selectedButton: string = 'recipes'; 
  
  selectButton(button: string): void {
    this.selectedButton = button;
    this.sectionChange.emit(button); 
  }
}
