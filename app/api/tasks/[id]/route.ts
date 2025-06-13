import { NextResponse } from "next/server"

export async function GET(request: Request, { params }: { params: { id: string } }) {
  // In a real app, this would fetch a specific task from your Laravel API
  const task = {
    id: params.id,
    title: "Sample Task",
    description: "This is a sample task",
    dueDate: "2023-12-15",
    completed: false,
    userId: "1",
  }

  return NextResponse.json(task)
}

export async function PUT(request: Request, { params }: { params: { id: string } }) {
  const body = await request.json()

  // In a real app, this would update a task in your Laravel API
  const updatedTask = {
    id: params.id,
    ...body,
    userId: "1",
  }

  return NextResponse.json(updatedTask)
}

export async function DELETE(request: Request, { params }: { params: { id: string } }) {
  // In a real app, this would delete a task in your Laravel API

  return NextResponse.json({ success: true })
}
