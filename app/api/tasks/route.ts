import { NextResponse } from "next/server"

// This would connect to your Laravel backend in a real application
// Here we're just mocking the API responses

export async function GET() {
  // In a real app, this would fetch from your Laravel API
  const tasks = [
    {
      id: "1",
      title: "Social Media Planning",
      description: "Plan social content for next month",
      dueDate: "2023-12-15",
      completed: false,
      userId: "1",
    },
    {
      id: "2",
      title: "Content Strategy",
      description: "Develop content strategy for Q1",
      dueDate: "2023-12-20",
      completed: false,
      userId: "1",
    },
  ]

  return NextResponse.json(tasks)
}

export async function POST(request: Request) {
  const body = await request.json()

  // In a real app, this would send data to your Laravel API
  // and return the newly created task
  const newTask = {
    id: Math.random().toString(36).substring(7),
    ...body,
    completed: false,
    userId: "1",
  }

  return NextResponse.json(newTask)
}
