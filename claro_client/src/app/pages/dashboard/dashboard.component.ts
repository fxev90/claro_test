import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AppService } from '@services/app.service';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
    topCourses: any[] = [];
    topStudents: any[] = [];

    constructor(private http: HttpClient, private appService: AppService) { }

    ngOnInit() {
        this.fetchTopCourses();
        this.fetchTopStudents();
    }

    fetchTopCourses() {
        this.http.get<any>(`${this.appService.apiUrl}/top-courses`)
            .subscribe(
                response => {
                    this.topCourses = response.data;
                },
                error => {
                    console.error('Error fetching top courses:', error);
                }
            );
    }

    fetchTopStudents() {
        this.http.get<any>(`${this.appService.apiUrl}/top-students`)
            .subscribe(
                response => {
                    this.topStudents = response.data;
                },
                error => {
                    console.error('Error fetching top students:', error);
                }
            );
    }
}