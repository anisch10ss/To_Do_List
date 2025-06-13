"use client"

import { Card, CardContent, CardHeader } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { MoreHorizontal, Check, Trash2, Edit } from "lucide-react"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

type Task = {
  id: string
  title: string
  description: string
  category: string
  color: string
}

interface TaskCardProps {
  task: Task
  onMarkComplete: (id: string) => void
}

export function TaskCard({ task, onMarkComplete }: TaskCardProps) {
  return (
    <Card className={`${task.color} border-none`}>
      <CardHeader className="p-4 pb-2 flex flex-row items-start justify-between space-y-0">
        <h4 className="font-medium text-sm">{task.title}</h4>
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" size="icon" className="h-8 w-8">
              <MoreHorizontal className="h-4 w-4" />
              <span className="sr-only">Open menu</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem onClick={() => onMarkComplete(task.id)}>
              <Check className="mr-2 h-4 w-4" />
              <span>Mark as completed</span>
            </DropdownMenuItem>
            <DropdownMenuItem>
              <Edit className="mr-2 h-4 w-4" />
              <span>Edit task</span>
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem className="text-destructive">
              <Trash2 className="mr-2 h-4 w-4" />
              <span>Delete task</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </CardHeader>
      <CardContent className="p-4 pt-2">
        <p className="text-xs text-muted-foreground">{task.description}</p>
      </CardContent>
    </Card>
  )
}
