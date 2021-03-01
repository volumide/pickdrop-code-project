import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AuthsidebarComponent } from './authsidebar.component';

describe('AuthsidebarComponent', () => {
  let component: AuthsidebarComponent;
  let fixture: ComponentFixture<AuthsidebarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AuthsidebarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AuthsidebarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
