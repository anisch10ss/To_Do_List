"use client"

import { useState } from "react"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Checkbox } from "@/components/ui/checkbox"
import { Button } from "@/components/ui/button"
import { Edit, Trash2 } from "lucide-react"

type Task = {
  id: string
  title: string
  description: string
  dueDate: string
  completed: boolean
}

export function TaskList() {
  const [tasks, setTasks] = useState<Task[]>([
    {
      id: "1",
      title: "Social Media Planning",
      description: "Plan social content for next month",
      dueDate: "2023-12-15",
      completed: false,
    },
    {
      id: "2",
      title: "Content Strategy",
      description: "Develop content strategy for Q1",
      dueDate: "2023-12-20",
      completed: false,
    },
    {
      id: "3",
      title: "Email A/B Tests",
      description: "Set up A/B tests for newsletter",
      dueDate: "2023-12-10",
      completed: true,
    },
    {
      id: "4",
      title: "Banner Ads Design",
      description: "Create new banner ads for campaign",
      dueDate: "2023-12-18",
      completed: false,
    },
  ])

  const toggleTaskCompletion = (taskId: string) => {
    setTasks(tasks.map((task) => (task.id === taskId ? { ...task, completed: !task.completed } : task)))
  }

  return (
    <div className="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead className="w-12"></TableHead>
            <TableHead>Title</TableHead>
            <TableHead>Description</TableHead>
            <TableHead>Due Date</TableHead>
            <TableHead className="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {tasks.map((task) => (
            <TableRow key={task.id} className={task.completed ? "bg-muted/50" : ""}>
              <TableCell>
                <Checkbox checked={task.completed} onCheckedChange={() => toggleTaskCompletion(task.id)} />
              </TableCell>
              <TableCell className={task.completed ? "line-through text-muted-foreground" : ""}>{task.title}</TableCell>
              <TableCell className={task.completed ? "text-muted-foreground" : ""}>{task.description}</TableCell>
              <TableCell className={task.completed ? "text-muted-foreground" : ""}>{task.dueDate}</TableCell>
              <TableCell className="text-right">
                <div className="flex justify-end gap-2">
                  <Button variant="ghost" size="icon">
                    <Edit className="h-4 w-4" />
                    <span className="sr-only">Edit</span>
                  </Button>
                  <Button variant="ghost" size="icon" className="text-destructive">
                    <Trash2 className="h-4 w-4" />
                    <span className="sr-only">Delete</span>
                  </Button>
                </div>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </div>
  )
}
